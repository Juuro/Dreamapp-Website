SortTable.ok = true;
if(!document.getElementsByTagName){
	alert('Browser unterstützt die Sortierfunktion nicht');
	SortTable.ok = false;
}

/*
	sort_table.js 
	http://javascript.jstruebig.de/javascript/74/
	
	Version 2.9/Datum 31.03.2010
	* Neues Attribut: class="sort_string" sortiert eine Spalte immer wie eine Zeichenkette
	* String.prototype.stripTag: Eine etwas verbesserte Funktion um HTML Code zu filtern
	
	Version 2.8/Datum 28.08.2009
	* die Zellen werden nicht mehr geclont, sondern direkt umgehängt (Zeile 224),
	  das hat den Vorteil, das in den meisten Browsern z.b. checkboxen nach der Sortierung
	  gecheckt bleiben (im IE 6 nicht)

	Version 2.7/Datum 14.08.2009
	* .sort() Funktion, um eine Spalte "von Hand" zu sortieren
	
	Version 2.6 / Datum: 07.06.2009
	* leere Zellen Bug
	* colspan (Danke an Mathias)

	Version 2.5 / Datum: 05.05.2009
	* ein paar Bugs beseitgt
	* sortier Geschwindigkeit verbessert

	Version 2.4 / Datum 26.11.2008
	* Die Prüfung des CSS Klassennamens in die Klasse eingebaut

	Version 2.3 / Datum 28.10.2008
	* ein Bug beim sortieren von Textfeldern beseitigt
	
	Version 2.2 / Datum 16.09.2008
	* sortiert auch Auswahlisten
	
	Version 2.1 /  Datum 05.09.2008
	* init() Funktion
	
	Version 2.0 / Datum: 02.09.2008
	* Neue schnellere Sortierroutine.
	* arbeitet mit dem Skript Zebratabelle zusammen 
	  http://javascript.jstruebig.de/javascript/75/
	
	Version: 1.0 / Datum: 28.11.2007
*/

// Das Element das angezeigt wird, wenn die Spalte abwärts sortiert ist
SortTable.up = String.fromCharCode(9660);
SortTable.alt_up = 'Aufwärts sortieren';

// Das Element das angezeigt wird, wenn die Spalte aufwärts sortiert ist
SortTable.down = String.fromCharCode(9650);
SortTable.alt_down = 'Abwärts sortieren';

// Farbe des Zeichens in der Spaltenüberschrift
SortTable.pointer_color = '#222';

// Die Bezeichnung der Klasse der Tabellen, die sortiert werden sollen
SortTable.className = 'sortable'; 



SortTable.init = function(){
	var t = document.getElementsByTagName('table');
	var ret = [];
	var regEx  = new RegExp('\\b' + SortTable.className + '\\b', 'i');
	for(var i = 0; i < t.length; i++) {
		if(SortTable.ok && t[i].className && regEx.test(t[i].className))
		ret.push(new SortTable(t[i]));
	}
	return ret;
}

function SortTable(theTable) {
	var self = this;
	var DATE_DE = /(\d{1,2})\.(\d{1,2})\.(\d{2,4})/;
	var zebra = /\bzebra\b/i.test(theTable.className);
	var tableBody = theTable.tBodies[0];
	var header = theTable.tHead;

	// SortTable Eventhandler, Dummy Funktionen
	self.onstart = self.onsort = function() {};
	
	this.length = function() { return tableBody.rows.length;};
	this.sort = function(spalte) {
	header.rows[0].cells[spalte].onclick();
	};
	
	if(!header) {
		/**
		 exisitert kein Headerelement:
		 neues Headerelement erzeugen, die erste Zeile in den Header umhängen 
		 und den Header in die Tabelle einfügen
		*/
		header = document.createElement('thead'); 
		header.appendChild(tableBody.rows[0]); 
		theTable.appendChild(header);
		// Wenn die Tabelle ein tFoot Objekt hat, ist der Body [1]
		tableBody = theTable.tBodies[1] || theTable.tBodies[0];
	}
	
	/**
	Die Headerzeile mit den Events und dem Marker versehen
	**/
	var th = header.rows[0].cells;
	var last_sort;
	
	var offset = 0; // für colspan
	for(var i = 0; i < th.length; i++) {
		// soll die Spalte sortiert werden
		if(th[i].className && /\bno_sort\b/i.test(th[i].className)) continue;
		
		// click Event
		th[i].onclick = ( function() { 
			// Den Zeiger einfügen
			var pointer = document.createElement('span');
			pointer.style.fontFamily = 'Arial';
			pointer.style.fontSize = '80%';
			pointer.style.visibility = 'hidden';
			pointer.innerHTML = SortTable.down;
			th[i].appendChild(pointer);
			
			// Lokale Werte
			var spalte = i + offset;
			var desc = 1;
			var ignoreCase = ((th[i].getAttribute('ignore_case') || th[i].title) == 'ignore_case');
			var forceString = !!(th[i].className && /\bsort_string\b/i.test(th[i].className));
			
			// und die Eventfunktion
			return function() {
				self.onstart(new Date());
				// Der Aufruf, der eigentlichen Sortierfunktion
				sort(spalte, desc, ignoreCase, forceString);
				
				// Sortierung umkehren
				desc = -desc;

				// Den Zeiger der zuletzt geklickten Spalte entfernen
				if(last_sort != pointer) {
					if(last_sort) last_sort.style.visibility = 'hidden';
					pointer.style.visibility = '';
					last_sort = pointer;
				}
				pointer.style.color = SortTable.pointer_color;
				pointer.innerHTML = desc < 0 ? SortTable.down : SortTable.up;
				this.title = desc < 0 ? SortTable.alt_down : SortTable.alt_up;

				self.onsort(new Date());
				
				return false;
				};
			})(); // Funktionsaufruf
		th[i].style.cursor = 'pointer';
		if(th[i].getAttribute('colspan')){
			offset += th[i].getAttribute('colspan') -1;
		}

	}

	/********************************************
	 * Hilfsfunktionen
	 ********************************************/
	function getValue(el, ignoreCase, forceString) {
		var val = getText(el).trim();
		if(forceString) return ignoreCase ? val.toLowerCase() : val;
		
		var d = val.match(DATE_DE);
		
		return val == parseFloat(val) ? parseFloat(val) : // Zahl
		d ? (new Date(d[3] + '/' + d[2] + '/' + d[1])).getTime():  // deutsches Datum
		!isNaN(Date.parse(val)) ? Date.parse(val) :
		ignoreCase ? val.toLowerCase() : val;
	}

	function getText(td) {
		if(td.getAttribute('my_key')) {
			return td.getAttribute('my_key');
		} else if(td.childNodes.length > 0) {
			// Enthält das Element HTML Knoten
			var input = td.getElementsByTagName('input')[0];
			if(input && input.type == 'text') {
				return input.value;
			} else if(td.getElementsByTagName('select')[0]) {
				return td.getElementsByTagName('select')[0].value;
			} else {
				// Enthält die Zelle HTML Code wird dieser entfernt 
				return td.innerHTML.stripTags();
			}
		} else if(td.firstChild){
				return td.firstChild.data;
		}
		return '';
	}
	
	/*
	Die Sortierfunktion sortiert die angegebene Spalte.
	*/
	function sort(spalte, desc, ignoreCase, forceString) { 
		var mySort = function (a, b) {
			return  a.value == b.value ? 0 :
			a.value > b.value ? desc : -desc;
		};
		/**
		Die Reihen der Tabelle zwischenspeichern
		*/
		var rows = [];
		var tr = tableBody.rows;
		var tr_length = tableBody.rows.length;

		for(var i = 0; i < tr_length; i++) {
			rows.push(
			{
				elem: tr[i], 
				value: getValue(tr[i].cells[spalte], ignoreCase, forceString) 
			});
		}
		// sortieren
		rows = rows.sort(mySort);

		// umhängen
		var tCopy = tableBody.cloneNode(false);
		for(var i = 0; i < tr_length; i++) {
				if(zebra) {
					rows[i].elem.className = rows[i].elem.className.replace(/( ?odd)/, "");
					if(i % 2) rows[i].elem.className += ' odd' ;
				}
				tCopy.appendChild(rows[i].elem);
				//tCopy.appendChild(rows[i].elem.cloneNode(true));
		}
		tableBody.parentNode.replaceChild(tCopy, tableBody);
		tableBody = tCopy;
	}
}

/**
* Entfernt HTML Tags funktioniert nicht, 
* wenn innerhalb der Tags in Attributen HTML Tags die in Anführungszeichen stehen
*
* <a title="Das funktioniert nicht '<br>'">
* <a title="Das funktioniert <br>">
*
*/
String.prototype.stripTags =  function(){
	// remove all string within tags
	var tmp = this.replace(/(<.*['"])([^'"]*)(['"]>)/g, function(x, p1, p2, p3) { return  p1 + p3;});
	// now remove the tags
	return tmp.replace(/<\/?[^>]+>/gi, '');
};