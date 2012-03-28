function entfernung1(f) {
    //f ist eine Referenz auf das Formular
    var startplanet = f.startplanet.value;
    var zielplanet = f.zielplanet.value;
    if (startplanet > zielplanet){
        f.ausgabe.value = (startplanet - zielplanet) * 5000 + 1000000;
    }
    else if (zielplanet > startplanet){
        f.ausgabe.value = (zielplanet - startplanet) * 5000 + 1000000;
    }
    else {
        f.ausgabe.value = "man kann nicht vom Startplanet zum Zielplanet fliegen du dumme Kuh";
    }
        
    
    //noch einbauen, dass wenn das textfeld leer ist, dass dann eine Null eingefügt wird.
}

function verschwindibus(v){
    if (v.value==v.value) { 
        v.value=''; 
    }
}


function wiederda(v){
    var va;
    if (v.id=='s1' || v.id=='z1'){
        v.value = 'Galaxie';
    }
    if (v.id=='s2' || v.id=='z2'){
        v.value = 'System';
    }
    if (v.id=='s3' || v.id=='z3'){
        v.value = 'Planet';
    }
        
    if (this.value==''){
        this.value=v;
    }
}