
<html>
<head>
<title>Made EC</title>
<script language="JavaScript" src="funktionen.js" />
<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<body>
<h3>Entfernung</h3>
<ul>
<form onsubmit="return false;">
        Start
        <br />
        <input type="text" value="Galaxie" id="s1" oninput="entfernung1(this.form); if (ausgabe.value=='NaN') { ausgabe.value='0'; }" onfocus="verschwindibus(this);" onblur="wiederda(this);" size="6" />
        <input type="text" value="System" id="s2" size="6" onfocus="verschwindibus(this);" onblur="wiederda(this);" />
        <input type="text" value="Planet" id="s3" size="6" onfocus="verschwindibus(this);" onblur="wiederda(this);" />
        
        <br />
        <br />
        
        Ziel
        <br />
        <input type="text" value="Galaxie" id="z1" oninput="entfernung1(this.form); if (ausgabe.value=='NaN') { ausgabe.value='0'; }" onfocus="verschwindibus(this);"  onblur="wiederda(this);" size="6" />
        <input type="text" value="System" id="z2" size="6" onfocus="verschwindibus(this);" onblur="wiederda(this);" />
        <input type="text" value="Planet" id="z3" size="6" onfocus="verschwindibus(this);" onblur="wiederda(this);" />
        
        <br />
        <br />
        
        Forschung
        <br />
        <input type="text" value="Forschung" id="forschung" onfocus="verschwindibus(this);" />
        
        <br />
        <br />
        
        Anfangsgeschwindigkeit
        <br />
        <input type="text" value="Geschwindigkeit" id="geschwindigkeit" onfocus="verschwindibus(this);" />
        
        <br />
        <!-- vielleicht einbauen, dass ein Hinweis angezeigt wird wenn man Buchstaben eingibt (Bitte geben sie gŸltige Zahlen ein) 
    ausgabe unbeschreibbar machen -->
    
        <textarea cols="20" rows="4" id="ausgabe" /> km
</form>
</ul>
</body>
</html>