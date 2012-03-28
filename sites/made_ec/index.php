<html>
<head>
<title>Made EC</title>
<script type="text/javascript"><!--
function entfernung1(f) {
    //f ist eine Referenz auf das Formular
    f.ausgabe.value = (f.startplanet.value - f.zielplanet.value) * 5000 + 1000000;
    
    //noch einbauen, dass wenn das textfeld leer ist, dass dann eine Null eingefŸgt wird.
}
//--></script>
</head>
<body>
<h3>Entfernung</h3>
<ul>
<form onsubmit="return false;">
    <fieldset>
        <!-- nach Attributen vom legend-Tag schauen -->
        <legend>innerhalb eines Systems</legend>
        <input type="text" value="Startplanet" name="startplanet" oninput="entfernung1(this.form); if (ausgabe.value=='NaN') { ausgabe.value='0'; }" onfocus="if (this.value=='Startplanet') { this.value=''; }" onblur="if (this.value=='') { this.value='Startplanet'; }" size="9" />
    
        <input type="text" value="Zielplanet" name="zielplanet" oninput="entfernung1(this.form); if (ausgabe.value=='NaN') { ausgabe.value='0'; }" onfocus="if (this.value=='Zielplanet') { this.value=''; }" onblur="if (this.value=='') { this.value='Zielplanet'; }" size="9" />
    
        <!--vielleicht einbauen, dass ein Hinweis angezeigt wird wenn man Buchstaben eingibt (Bitte geben sie gŸltige Zahlen ein) 
    ausgabe unbeschreibbar machen -->
    
        <input type="test" name="ausgabe"  /> km
    </fieldset>
</form>
</ul>

</body>
</html>