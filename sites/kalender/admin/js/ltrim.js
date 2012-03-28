/*
  stripNL()           - Alle Newlines entfernen
  trim([true/false])  - alle Leerzeichen am Anfang und Ende entfernen m. Parame doppelte einfach machen
  ltrim()             - Leerzeichen Links entfernen
  rtrim()             - Leerzeichen Rechts entfernen

*/
String.prototype.trim = function (ws)
{
    if(!this.length) return "";
    var tmp = this.stripNL().ltrim().rtrim();
    if(ws) return tmp.replace(/ +/g, ' ');
    else return tmp;
}
String.prototype.rtrim = function ()
{
    if(!this.length) return "";
    return this.replace(/\s+$/g, '');
}

String.prototype.ltrim = function ()
{
    if(!this.length) return "";
    return this.replace(/^\s+/g, '');
}
String.prototype.stripNL = function ()
{
    if(!this.length) return "";
    return this.replace(/[\n\r]/g, '');
}