<html>
<head>
<title>.::paranews [help]::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="pn_styles.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<br /><br />
<p align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="4"><b>.::Der UBB-Code::.</b></font></p>
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>UBB-Code?</b></td>
  </tr>
  <tr> 
    <td> 
      <p><br />
        Der UBB-Code ist eine Sammlung von Befehlen, die es dem Benutzer erm&ouml;glichen, 
        ohne HTML-Kenntnisse z.B. einen Text zu formatieren, Links und Bilder 
        sowie eMail-Adressen einzuf&uuml;gen.</p>
      <p>Paranews unterst&uuml;tzt den UBB-Code und somit k&ouml;nnt ihr folgende 
        Befehle verwenden:<br />
        (UBB-Code ist jeweils <font color="#CC0000">rot</font> gekennzeichnet)<br />
        <br />
      </p>
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>1. URL Hyperlinking</b></td>
  </tr>
  <tr> 
    <td> 
      <p> </p>
      <p><br />
        Um einen Hyperlink zu erzeugen, reicht es aus, folgenden Code zu schreiben:</p>
      <blockquote> 
        <p><font color="#CC0000">[url]</font>www.domain.de<font color="#CC0000">[/url]</font> 
          ergibt: <a href="http://www.domain.de">http://www.domain.de</a><br />
          <font color="#CC0000">[url=</font>http://www.domain.de<font color="#CC0000">]</font>Die 
          Internetadresse<font color="#CC0000">[/url]</font> ergibt: <a href="http://www.domain.de">Die 
          Internetadresse</a><br />
        </p>
      </blockquote>
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>2. eMail-Links</b></td>
  </tr>
  <tr> 
    <td> 
      <p><br />
        Um eine eMail-Adresse zu einem anklickbaren Link zu verwandeln, gen&uuml;gt 
        folgender Code:</p>
      <blockquote> 
        <p><font color="#CC0000">[email]</font>meine@email.de<font color="#CC0000">[/email]</font> 
          ergibt: <a href="mailto:meine@email.de">meine@email.de</a></p>
      </blockquote>
      <p>Es ist auch m&ouml;glich, einen richtigen eMail-Hyperlink zu erstellen:</p>
      <blockquote> 
        <p><font color="#CC0000">[email=</font>meine@email.de<font color="#CC0000">]</font>meine 
          eMail<font color="#CC0000">[/email]</font> <a href="meine@email.de">meine 
          eMail</a><br />
        </p>
      </blockquote>
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>3. Textformatierungen</b></td>
  </tr>
  <tr> 
    <td>Um den Text zu formatieren, gibt es drei Befehle: 
      <blockquote> 
        <p><font color="#CC0000">[u]</font>Text<font color="#CC0000">[/u]</font> 
          ergibt: <u>Text<br />
          </u><font color="#CC0000">[b]</font>Text<font color="#CC0000">[/b]</font> 
          ergibt: <b>Text<br />
          </b><font color="#CC0000">[i]</font>Text<font color="#CC0000">[/i]</font> 
          ergibt: <i>Text<br />
          </i><font color="#CC0000">[s]</font>Text<font color="#CC0000">[/s]</font> 
          ergibt: <s>Text</s></p>
      </blockquote>
      </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>4. Liste</b></td>
  </tr>
  <tr> 
    <td><br />
      Mit ParaNews k&ouml;nnen auch Listen erzeugt werden: 
      <blockquote>
        <p><font color="#CC0000">[list]</font><br />
          <font color="#CC0000">[*]</font>erster Listenpunkt<br />
          <font color="#CC0000">[*]</font>zweiter Listenpunkt<br />
          <font color="#CC0000">[*]</font>dritter Listenpunkt<br />
          <font color="#CC0000">[/list]</font><br />
          </p>
      </blockquote>ergibt:
      <ul>
        <li>erster Listenpunkt</li>
        <li>zweiter Listenpunkt</li>
        <li>dritter Listenpunkt</li>
      </ul>
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>5. Bilder</b></td>
  </tr>
  <tr> 
    <td><br />
      Um Bilder einzuf&uuml;gen, gibt es zwei M&ouml;glichkeiten: 
      <blockquote> 
        <p><font color="#CC0000">[img=</font>http://www.domain.de/bild.gif<font color="#CC0000">]</font> 
          <br />
          und<br />
          <font color="#CC0000">[url=</font>http://www.domain.de<font color="#CC0000">][img=</font>http://www.domain.de/bild.gif<font color="#CC0000">][/url]</font></p>
      </blockquote>
      <p>Im ersten Fall wird nur das Bild eingef&uuml;gt, im zweiten Fall werd 
        das Bild auch mit einer URL verlinkt (hier: http://www.domain.de ). Damit 
        der IMG-Code funktioniert, MUSS die vollst&auml;ndige URL des Bildes angegeben 
        werden, d.h. mit f&uuml;hrendem http:// !<br />
      </p>
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>6. Zitierter Text</b></td>
  </tr>
  <tr> 
    <td><br />
      Um einen zitierten Text innerhalb des Beitrags darzustellen, gen&uuml;gt 
      folgender Code: 
      <blockquote>
        <p><font color="#CC0000">[quote]</font>Dies ist zitierter Text<font color="#CC0000">[/quote] 
          </font></p>
      </blockquote>
      <p>ergibt:</p>
      <table width="300" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td>Quote: 
            <hr>
            Dies ist zitierter Text 
            <hr>
          </td>
        </tr>
      </table>
      <br />
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>7. Programm-Code</b></td>
  </tr>
  <tr> 
    <td><br />
      Um Code z.B. aus einem Programm in den Beitrag einzubinden, gibt es folgenden 
      Befehl: 
      <blockquote>
        <p><font color="#CC0000">[code]</font><br />
          &lt;?PHP<br />
          echo &quot;Hallo Welt&quot;;<br />
          ?&gt;<br />
          <font color="#CC0000">[/code] </font></p>
      </blockquote>
      <p>ergibt:</p>
      <table width="300" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td> 
            <blockquote>Quellcode: 
              <hr>
              <pre><br />&lt;?PHP<br />echo &quot;Hallo Welt&quot;;<br />?&gt;<br /></pre>
              <hr>
            </blockquote>
          </td>
        </tr>
      </table>
      <br />
    </td>
  </tr>
</table>
<br />
<table width="80%" border="0" cellspacing="1" cellpadding="1" bgcolor="#000000" align="center">
  <tr> 
    <td><b>8. Falscher UBB-Code</b></td>
  </tr>
  <tr> 
    <td>
      <blockquote>
        <p><font color="#CC0000"><br />
          [url]</font>http://www.domain.de<font color="#CC0000">[url]</font> Der 
          Slash im zweiten url-Tag fehlt ( [/url] )<br />
          <font color="#CC0000">[url]</font> http://www.domain.de<font color="#CC0000"> 
          [url]</font> oder<br />
          <font color="#CC0000">[ url ]</font> http://www.domain.de<font color="#CC0000"> 
          [ /url ]</font> Es d&uuml;rfen keine zus&auml;tzlichen Leerzeichen eingef&uuml;gt 
          werden<br />
        </p>
      </blockquote>
    </td>
  </tr>
</table>
</body>
</html>
