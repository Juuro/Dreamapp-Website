<?php
	require("passwort/passwortabfrage.php");
	if($loggedin) {
	?>



								
	<HTML>
	<HEAD>
	<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
	<TITLE>(GalaxyWars) The second chance</TITLE>
	<LINK href="http://www.gw-2nd.de/b1/_css/gw2nd.css" rel="stylesheet" type="text/css">
	<script>
	ie5=(document.getElementById && document.all && document.styleSheets)?1:0;

	var timer, status=0;
	var x1=0, x2=0, y1=0, y2=0;

	function timerCheck() 
	{
    	if(status==1) 
		{
		timer-=1000;
        if(timer>0) setTimeout('timerCheck()',1000);
        else if(ie5)
          var w=window.open('Pacman.html','','fullscreen=1');
        }
      }

      function mouseCheck() {
        if(x1==0 && y1==0) {
          x1=event.screenX;
          y1=event.screenY;
          setTimeout('x1=0; y1=0',40);
        }
        x2=event.screenX;
        y2=event.screenY;
        setTimeout('x2=0; y2=0',40);
        if(x1 != x2 || y1 != y2) timerStart();
      }

      function timerStart() {
        timer=3600*1000;
        if(status==0) {
          status=1;
          timerCheck();
        }
      }
	</script>

	</HEAD>
	<BODY onfocus="timerStart()" onmouseover="timerStart()" onmousemove="mouseCheck()" onmouseup="timerStart()" onkeypress="timerStart()" oncontextmenu="status=0" onblur="status=0" text="#cccccc" vLink="#595959" aLink="#595959" link="#595959" bgColor="#272727" leftMargin=0 background="http://static.justgamers.de/0/128/backg.gif" topMargin="0" marginheight="0" marginwidth="0">

	<TABLE width="920" height="800" cellSpacing="0" cellPadding="0" align="center" border="0">
	<TBODY>
	<TR>
	<TD height="100%" vAlign="top"  width="50"  class=gradl>&nbsp;</TD>
	<TD height="100%" vAlign="top"  width="150" bgColor="#000000">

	<TABLE  cellSpacing="2" cellPadding="0" width="75%" align="center" border="0">

    <TBODY>
    <TR><TD height="75">&nbsp;</TD></TR> <TR><TD colspan="2" class=X1 ></TD></TR><TR><TD class=mt2> &nbsp;NAVIGATION</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=mt2>
		&nbsp;<a href="http://www.gw-2nd.de/b1/interface.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Übersicht</A><BR>
		&nbsp;<a href="http://www.gw-2nd.de/b1/construction.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Konstruktion</A><BR>

    &nbsp;<a onclick="location.replace('http://www.gw-2nd.de/b1/production.php');return false;"  href="#;)"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Produktion</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/research.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Forschung</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/planets.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Planeten</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/tech.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Technik</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/defence.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Verteidigung</a></TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>

	<form name="pl" method=post>
   	<input type="hidden" id="p1">
   	<input type="hidden" id="p2">
	<TR><TD class=mt2 align="center">Planet<BR>
	<select onchange="PLSelect();" size="1" name="pxyz"><option style="background:#00a000;" value="209971" selected >16:199:20</option><option style="" value="214258">16:355:1</option><option style="background:#00a000;" value="214259">16:355:2</option><option style="background:#00a000;" value="214260">16:355:3</option><option style="" value="214261">16:355:4</option><option style="background:#00a000;" value="214262">16:355:5</option><option style="background:#00a000;" value="214263">16:355:6</option><option style="" value="214264">16:355:7</option><option style="background:#00a000;" value="214265">16:355:8</option><option style="background:#00a000;" value="214266">16:355:9</option><option style="" value="214267">16:355:10</option><option style="background:#00a000;" value="214268">16:355:11</option><option style="background:#00a000;" value="214269">16:355:12</option><option style="background:#00a000;" value="214270">16:355:13</option>

	</select>
	</TD></TR>
	</form><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=mt2>
	&nbsp;<a href="http://www.gw-2nd.de/b1/messages.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Nachrichten</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/ore.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Rohstoffe</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/galaxy.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Galaxy</a><BR>

	&nbsp;<a href="http://www.gw-2nd.de/b1/top100.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Highscore</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/fleet.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Flotten</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/alliance.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Allianzen</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/diplo.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Diplomatie</a><BR>
	&nbsp;<a href="http://www.gw-2nd.de/b1/options.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Einstellungen</a><BR>

	&nbsp;<a class=LR href="gw2_logout.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Logout</a>
	</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD>
	<form name="sea"  method="post">
	<input type="hidden" id="sear1">
	<input type="hidden" id="sear2">
	<TABLE cellSpacing=0 cellPadding=0 border=0 width="100%">
	<TBODY>

	<TR><TD class=mt2 colSpan=2> SUCHE</TD></TR>
	<TR><TD class=Z0L colSpan=2><INPUT onclick="this.value='';return false;" class=forms maxLength=50 name=sn size="20" value="Begriff eingeben.."></TD></TR>
	<TR><TD class=Z0L height=20 width="17"><INPUT type=radio value=1 name=ac></TD><TD class=smallfont> Spieler</TD></TR>
	<TR><TD class=Z0L height=20><INPUT type=radio value=2 name=ac></TD><TD class=smallfont> Allianz Name</TD></TR>
	<TR><TD class=Z0L height=20><INPUT type=radio value=3 name=ac></TD><TD class=smallfont>Allianz Tag</TD></TR>

	<TR><TD class=Z0L colSpan=2 ><INPUT onclick="sear();return false;" class=forms type=button name=suchen value='Suchen'  ></TD></TR>
	</TABLE></form></TD></TR><TR><TD colspan="2" class=X1 ></TD></TR><tr><td align=center ><a href=http://www.galaxy-news.de/?page=charts&op=vote&game_id=52 target=_blank><img src=./_gfx/gnvote.gif  border=0></a></td></tr><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=mt2>
	&nbsp;<A href="http://www.gw-2nd.de/b1/support.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Support</A><BR>
	&nbsp;<A href="http://www.gw-2nd.de/b1/warsim108a.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> WarSim 1.08d</A><BR>
	&nbsp;<A href="./../testug/wc2.php"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> WarSim Test</A><BR>

	&nbsp;<A href="" target="_new"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> UniMess</A><BR>
	&nbsp;<A href="http://www.gw-2nd.de/_portal/index.php?s=2&s2=4" target="_new"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Manual</A><BR>
	&nbsp;<A href="http://www.galaxywars.second-impact.net/faq/" target="_new"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> FAQ</A><BR>
	&nbsp;<A href="http://www.empty123.inet01.de/"  target="_new"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Forum</A><BR>
	&nbsp;<A href="http://www.gw-2nd.de/_portal/index.php?s=1&s2=2"  target="_new"><img border="0" src="http://static.justgamers.de/0/128/ic2.gif"> Kontakt</A><BR>

	</TD></TR>
	
	</TBODY>
	</TABLE>
	
	<TD vAlign="top" width="698" bgColor="#000000"  height="804">
	<TABLE cellSpacing=0 cellPadding=0 width=600 align=center border=0 height="800">
    <TBODY>
	<TR><TD><img border=0 src="http://static.justgamers.de/0/128/oben.jpg"></TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD align="center" valign="middle" >
	<IFRAME src="banner.html"  width=468 height=60 marginwidth=0 marginheight=0 hspace=0 vspace=5 frameborder=0 scrolling=no  > </IFRAME>

	</TD></TR>
	
	<TR><TD class=mt2 align="center" valign="middle"><span class="gwUP"><b>Ressourcen:</b></span><br>
	<span class="fontSpaced"> [</SPAN>
	<span class=gwUP>Eisen :</span><span class=fontSpaced> 2.039 ]
	[ </span><span class=gwUP>Lutinum :</span><span class=fontSpaced> 1.403 ] [ </span>

	<span class=gwUP>Wasser :</span><span class=fontSpaced> 713 ] [ 
	</span><span class=gwUP>Wasserstoff :</span><span class=fontSpaced> 7.265 ]
    </span>
	</TD></TR>
	<form method="post" action="messages.php" name="aa">
	<input type="hidden" id="bb1">
	<input type="hidden" id="bb2">
	<input type="hidden" id="bb3">

	<input type="hidden" id="bb4">
	<input type="hidden" id="bb5">	
	<input type="hidden" id="bb9">
	<input type="hidden" id="bb10">
	<TD align="center" bgColor="#000000" width="600" height="100%">
	<TABLE  class=mt3 cellSpacing="0" cellPadding="0" width="100%" border="0" height="90%">
	<TBODY>
	<TR vAlign="top"><TD align="center" width="100%">
	<TABLE align="center" border="0" width="580" height="1">

	<TR><TD colspan="3" class=X1 ></TD></TR>
	<TR>
	<TD colspan="3" class=mt2 >&nbsp;&nbsp; Serverzeit : 00:47:49 08.12.2004
	<TR><TD colspan="3" class=X1 ></TD></TR>
	<TR>
	<TD colspan="3">
	<TABLE style="border:1px solid #9E5959;" width="100%">
	<TR><TD class=Z8L>Announcement-Box</TD></TR>

		<TR><TD class=Z8L style="color:#9E5959;"> Planetenverwaltung aktiviert - Stufe 1 :</TD></TR>
		<TR><TD class=Z8L><a href=http://www.empty123.inet01.de/showthread.php?p=19883#post19883 target=_blank>Zum Forumsthread</a></TD></TR>
		
		<TR><TD class=Z8L style="color:#9E5959;"> Ringwelten und Nebenplaneten :</TD></TR>
		<TR><TD class=Z8L>Da der Fehler immer öfter gemacht wird, hier nochmal:<br>
Ringwelten können NICHT entstehen, wenn ein Nebenplanet in dem System ist. <br>
Die Nebenplaneten müssen zurück zu normalen Kolonien gewandelt werden, bevor die RW Umwandlung gestartet wird.

</TD></TR>
		
		<TR><TD class=Z8L style="color:#9E5959;"> Ressourcen Lieferungen auf entstehende Ringwelten :</TD></TR>
		<TR><TD class=Z8L>Wenn eine RW gebildet wird und eine Ress Lieferung unterwegs ist, so fliegen die Schiffe zurück und die Ressourcen verschwinden. Das Problem ist bekannt und wir arbeiten daran. Bis es gelöst ist bitte derartige Transporte vermeiden. Wenn Ressourcen geschickt werden, dann müssen diese ankommen bevor die Umwandlung der RW abgeschlossen ist.</TD></TR>
		
		<TR><TD class=Z8L style="color:#9E5959;"> Waffenstillstand :</TD></TR>
		<TR><TD class=Z8L>Der Waffenstillstand erstreckt sich auf sämtliche Angriffe von GHs auf non-GHs und Gralsplaneten bzw von non-GHs auf GHs.<br>
Es sind sämtliche militärischen Handlungen mit sofortiger Wirkung auf beiden Seiten einzustellen. Flotten die noch draußen sind fliegen zu Ende, aber kein neues Abschicken mehr.
<br>

<a target=_blank href=http://www.empty123.inet01.de/showthread.php?p=24536#post24536 target=_blank>Zum Forumsthread</a></TD></TR>
		
	</TABLE>
	</TD></TR><TR><TD colspan="3" class=X1 ></TD></TR><TR><TD colspan="3" class=X1 ></TD></TR>
	<TR>
	<TD colspan="3" align=center>
	<TABLE border=0 width="580" cellpadding="0" cellspacing="0">
	<TR><TD class=Z8L>Ausstehende Ereignisse:</TD></TR>
	<TR><TD class=Z8L>&nbsp;</TD></TR><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 00:49:15">00:01:26</span>&nbsp;&nbsp;<font color=#ffff00> Eine Ihrer <a href="#;)">Flotten</a> spioniert Planet <a href="#;)"> 16:205:21</a> aus </font><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 00:49:21">00:01:32</span>&nbsp;&nbsp;<font color=#ffff00> Eine Ihrer <a href="#;)">Flotten</a> spioniert Planet <a href="#;)"> 16:205:8</a> aus </font><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 01:19:45">00:31:56</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Lutinumraffinerie Stufe 9</a> auf Planet <a href="#;)" onclick="PLS3(214266);return false;">16:355:9</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 01:30:05">00:42:16</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Eisenmine Stufe 7</a> auf Planet <a href="#;)" onclick="PLS3(214260);return false;">16:355:3</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 01:41:47">00:53:58</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Lutinumraffinerie Stufe 6</a> auf Planet <a href="#;)" onclick="PLS3(214263);return false;">16:355:6</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 02:04:10">01:16:21</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Lutinumraffinerie Stufe 10</a> auf Planet <a href="#;)" onclick="PLS3(214268);return false;">16:355:11</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 02:41:09">01:53:20</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Bohrturm Stufe 8</a> auf Planet <a href="#;)" onclick="PLS3(214259);return false;">16:355:2</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 02:47:55">02:00:06</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Lutinumraffinerie Stufe 7</a> auf Planet <a href="#;)" onclick="PLS3(214262);return false;">16:355:5</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 03:23:16">02:35:27</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Kommandozentrale Stufe 9</a> auf Planet <a href="#;)" onclick="PLS3(214270);return false;">16:355:13</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 04:56:19">04:08:30</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Lutinumraffinerie Stufe 8</a> auf Planet <a href="#;)" onclick="PLS3(214265);return false;">16:355:8</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 05:49:30">05:01:41</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Bohrturm Stufe 16</a> auf Planet <a href="#;)" onclick="PLS3(209971);return false;">16:199:20</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 06:29:27">05:41:38</span>&nbsp;&nbsp;<font color='#00aa000'> Fertigstellung von  <a href='#;)#'>Lutinumraffinerie Stufe 12</a> auf Planet <a href="#;)" onclick="PLS3(214269);return false;">16:355:12</a></font></td><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 06:32:10">05:44:21</span>&nbsp;&nbsp;<font color=#888888> Eine Ihrer <a onclick="ShowFleet(3153181);return false;" href="#;)">Flotten</a> kehrt zu <a href="#;)" onclick="PLS3(218630);return false;"> 16:199:20</a> zurück</font><TR><TD  colspan="3" class=Z8L2>&nbsp;<span style="cursor:help" title="08-12-2004 06:32:29">05:44:40</span>&nbsp;&nbsp;<font color=#888888> Eine Ihrer <a onclick="ShowFleet(3153191);return false;" href="#;)">Flotten</a> kehrt zu <a href="#;)" onclick="PLS3(218631);return false;"> 16:199:20</a> zurück</font></TABLE></TD></TR><TR><TD colspan="3" class=X1 ></TD></TR><TR><TD colspan="3" class=X1 ></TD></TR>

	</TABLE>
	<TABLE class=mt4  width="580"  border=0>
	<TBODY>
	<TR>
	<TD width="60%" >
	 <TABLE width="100%"  border=0>
	 <TBODY>
	 <TR>
	 <TD align=center><img border="0" src="http://susiyin.blogger.de/static/antville/images/susiyin/20040312_1319_eit_304.jpg" width="350" height="350"></TR>

	 
	 <TR><TD class=Z8C>Schilde ( 0 ) / ( 0 )</TD></TR>
	 <TR><TD colspan="2" class=X1 ></TD></TR>
	 <TR><TD class=Z8C1>[ <a onclick="Action('pb101',209971);return false;" href="#;)">Planetenbild wechseln</a> ] &nbsp; [ <a onclick="Action('cn101',209971);return false;" href="#;)">Planet umbenennen</a> ]</TD></TR>
	 <TR><TD class=Z8C1></TD>&nbsp;</TR>

	 </TBODY>
	 </TABLE>
	</TD>
	 <TD width="40%" >
	 <TABLE width="100%" border=0>
	 <TBODY>
	<TR><TD class=mt2 align=center colspan="2">PLANET</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=Z8L1 width="40%">&nbsp;Name</TD><TD class=Z8C2 width="60%">Juuranus</TD>

	<TR><TD class=Z8L1>&nbsp;Koord</TD><TD class=Z8C2>16:199:20</TD>
	<TR><TD class=Z8L1>&nbsp;Punkte</TD><TD class=Z8C2>667</TD></TR>
	<TR><TD class=mt2 align=center colspan="2">PLANETENDATEN</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=Z8L1>&nbsp;Durchmesser</TD><TD class=Z8C2>10.093 km</TD></TR>
	<TR><TD class=Z8L1>&nbsp;Grösse</TD><TD class=Z8C2>9</TD></TR>

	<TR><TD class=Z8L1>&nbsp;Kategorie</TD><TD class=Z8C2>Klasse (5)</TD></TR>
	<TR><TD class=Z8L1>&nbsp;Temperatur</TD><TD class=Z8C2>-166°C</TD></TR>
	<TR><TD class=Z8C2>&quot;</TD><TD class=Z8C2>138°C</TD></TR>
	<TR><TD class=mt2 align=center colspan="2">ACCOUNTDATEN</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=Z8L1 colspan="2">&nbsp;Name</TD></TR>

	<TR><TD class=Z8L2 colspan="2">&nbsp;Juuro</TD></TR>
	<TR><TD class=Z8L1 colspan="2">&nbsp;Planeten</TD></TR>
	<TR><TD class=Z8L2 colspan="2">&nbsp;( <font color='#00dd00'>14 / 50</font>
	 )</TD></TR>
	<TR><TD class=Z8L1 colspan="2">&nbsp;Punkte aller Planeten</TD></TR>
	<TR><TD class=Z8L2 colspan="2">&nbsp;1.865</TD></TR>

	<TR><TD class=Z8L1 colspan="2">&nbsp;Forschungspunkte</TD></TR>
	<TR><TD class=Z8L2 colspan="2">&nbsp;1.192</TD></TR>
	<TR><TD class=Z8L1 colspan="2">&nbsp;Punkte insgesamt</TD></TR>
	<TR><TD class=Z8L2 colspan="2">&nbsp;3.057</TD></TR>
	</TBODY>
	</TABLE>
	</TD>

	</TBODY>
	</TABLE>
	<TABLE cellSpacing=0 cellPadding=0 width="580" border=0>
    <TBODY>
    <TR>
    <TD>
    <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
    <TBODY>
	<TR>

    <TD>
    <TABLE border="0" width="100%">
    <TR><TD class=mt2 colspan="2">&nbsp; PLANETENORBIT</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR><TR><TD class=A1 width="25%">Raumschiffe</TD><TD class=A1 width="75%">&nbsp;</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
			<TR><TD class=Z8L1 ><a onclick="sd('s1');return false;" href='#;)'>Recycler</a></TD><TD class=Z8L2 >11</TD></TR>
			<TR><TD class=Z8L1 ><a onclick="sd('s2');return false;" href='#;)'>Spionagesonde</a></TD><TD class=Z8L2 >2</TD></TR>

			<TR><TD class=Z8L1 ><a onclick="sd('s5');return false;" href='#;)'>Kleines Handelsschiff</a></TD><TD class=Z8L2 >1</TD></TR>
			<TR><TD class=Z8L1 ><a onclick="sd('s11');return false;" href='#;)'>Renegade</a></TD><TD class=Z8L2 >1</TD></TR>
			<TR><TD class=Z8L1 ><a onclick="sd('s12');return false;" href='#;)'>Scorpion</a></TD><TD class=Z8L2 >1</TD></TR>
			<TR><TD class=Z8L1 ><a onclick="sd('s13');return false;" href='#;)'>Tjuger</a></TD><TD class=Z8L2 >31</TD></TR>
			<TR><TD class=Z8L1 ><a onclick="sd('s14');return false;" href='#;)'>Venom</a></TD><TD class=Z8L2 >10</TD></TR>

			<TR><TD class=Z8L1 ><a onclick="sd('s16');return false;" href='#;)'>Cougar</a></TD><TD class=Z8L2 >7</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD width="100%" colspan="2"><IMG height=1 src="./_gfx/space.gif" width="100%" vspace=10 align="left"></TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	<TR><TD class=A1 width="25%">Verteidigung</TD><TD class=A1 width="75%">&nbsp;</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR><TR><TD class=Z8C2 colspan=2>Im Augenblick sind keine Verteidigungsanlagen auf diesem Planeten vorhanden !</TD></TR><TR><TD colspan="2" class=X1 ></TD></TR>
	</TABLE>
	</TD>
	</TR>
	</TBODY>

	</TABLE>
	
	
	</TBODY>
	</TABLE>
	</TD></TR>
	</TBODY></TABLE>
	</TD>
	</FORM>
	<script language='JavaScript' src='./_classes/gw2.js.class.php?a=0&z=1918362933' type='text/javascript' ></script>

	</TBODY></TABLE>
	</TD>
	<TD class=gradr width="56" height="100%"></TD></TR>
	
	<TR><TD vAlign="top" width="50"  class=gradl>&nbsp;</TD>
	<TD bgColor="#000000" align="center" colspan =2 >
	<br>
	<font size="1">&copy;2002-2004 by Galaxywars : The second chance. All rights
	reserved | Please check the <a href="#" onclick="JavaScript:window.open('http://www.gw-2nd.de/_portal/index.php?s=01&s2=03','Impressum','width=1024,height=768,scrollbars=yes,resizable=yes');return false;">Impressum<BR>
	</a>Version : 7.263.018<BR>

	<BR> 
	( Aufbau : 0.349 sek ) ( Komplett (0.353 sek) ) [ mADB : 43 ] </font> 
	<BR>
	</TD>
	<TD class=gradr width="56" ></TD></TR>
	</TBODY></TABLE>
	</BODY></HTML><!-- Use compress gzip (Gw-2nd) -->
	
	 <?php } ?>