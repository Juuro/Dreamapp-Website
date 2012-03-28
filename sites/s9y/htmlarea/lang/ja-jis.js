// I18N constants -- Japanese JIS(ISO-2022-JP)

// LANG: "ja-jis", ENCODING: ISO-2022-JP
// Author: Mihai Bazon, http://dynarch.com/mishoo
// Translator:  
//   Manabu Onoue <tmocsys@tmocsys.com>, 2004.
//   Tadashi Jokagi <elf2000@users.sourceforge.net>, 2005.

HTMLArea.I18N = {

	// the following should be the filename without .js extension
	// it will be used for automatically load plugin language.
	lang: "ja-jis",

	tooltips: {
		bold:           "$BB@;z(B",
		italic:         "$B<PBN(B",
		underline:      "$B2<@~(B",
		strikethrough:  "$BBG$A>C$7@~(B",
		subscript:      "$B2<IU$-E:$(;z(B",
		superscript:    "$B>eIU$-E:$(;z(B",
		justifyleft:    "$B:84s$;(B",
		justifycenter:  "$BCf1{4s$;(B",
		justifyright:   "$B1&4s$;(B",
		justifyfull:    "$B6QEy3dIU(B",
		orderedlist:    "$BHV9fIU$-2U>r=q$-(B",
		unorderedlist:  "$B5-9fIU$-2U>r=q$-(B",
		outdent:        "$B%$%s%G%s%H2r=|(B",
		indent:         "$B%$%s%G%s%H@_Dj(B",
		forecolor:      "$BJ8;z?'(B",
		hilitecolor:      "$BGX7J?'(B",
		horizontalrule: "$B?eJ?@~(B",
		createlink:     "$B%j%s%/:n@.(B",
		insertimage:    "$B2hA|A^F~(B",
		inserttable:    "$B%F!<%V%kA^F~(B",
		htmlmode:       "HTML$BI=<(@ZBX(B",
		popupeditor:    "$B%(%G%#%?3HBg(B",
		about:          "$B%P!<%8%g%s>pJs(B",
		showhelp:       "Help using editor",
		textindicator:  "$B8=:_$N%9%?%$%k(B",
		undo:           "$B:G8e$NA`:n$r<h$j>C$7(B",
		redo:           "$B:G8e$NF0:n$r$d$jD>$7(B",
		cut:            "$BA*Br$r@Z$j<h$j(B",
		copy:           "$BA*Br$r%3%T!<(B",
		paste:          "$B%/%j%C%W%\!<%I$+$iE=$jIU$1(B",
		lefttoright:    "$B:8$+$i1&$NJ}8~(B",
		righttoleft:    "$B1&$+$i:8$NJ}8~(B",
		removeformat:   "$B=q<0$r<h$j=|$/(B",
		print:          "$B%I%-%e%a%s%H$r0u:~(B",
		killword:       "MSOffice $B%?%0$r<h$j=|$/(B"
	},

	buttons: {
		"ok":           "OK",
		"cancel":       "$B<h$j>C$7(B"
	},

	msg: {
		"Path":         "$B%Q%9(B",
		"TEXT_MODE":    "$B%F%-%9%H%b!<%I$G$9!#(B[<>] $B%\%?%s$r;H$C$F(B WYSIWYG $B$KLa$j$^$9!#(B",

		"IE-sucks-full-screen" :
		// translate here
		"The full screen mode is known to cause problems with Internet Explorer, " +
		"due to browser bugs that we weren't able to workaround.  You might experience garbage " +
		"display, lack of editor functions and/or random browser crashes.  If your system is Windows 9x " +
		"it's very likely that you'll get a 'General Protection Fault' and need to reboot.\n\n" +
		"You have been warned.  Please press OK if you still want to try the full screen editor.",

		"Moz-Clipboard" :
		"Unprivileged scripts cannot access Cut/Copy/Paste programatically " +
		"for security reasons.  Click OK to see a technical note at mozilla.org " +
		"which shows you how to allow a script to access the clipboard."
	},

	dialogs: {
		// Common
		"OK"                                                : "OK",
		"Cancel"                                            : "$B<h$j>C$7(B",

		"Alignment:"                                        : "$B0LCV9g$o$;(B:",
		"Not set"                                           : "$B@_Dj$7$J$$(B",
		"Left"                                              : "$B:8(B",
		"Right"                                             : "$B1&(B",
		"Texttop"                                           : "Texttop",
		"Absmiddle"                                         : "Absmiddle",
		"Baseline"                                          : "$B%Y!<%9%i%$%s(B",
		"Absbottom"                                         : "Absbottom",
		"Bottom"                                            : "$B2<(B",
		"Middle"                                            : "$BCf1{(B",
		"Top"                                               : "$B>e(B",

		"Layout"                                            : "$B%l%$%"%&%H(B",
		"Spacing"                                           : "$B4V3V(B",
		"Horizontal:"                                       : "$B?eJ?(B:",
		"Horizontal padding"                                : "$B?eJ?$N7d4V(B",
		"Vertical:"                                         : "$B?bD>(B:",
		"Vertical padding"                                  : "$B?bD>$N7d4V(B",
		"Border thickness:"                                 : "$B6-3&@~$NB@$5(B:",
		"Leave empty for no border"                         : "$B6-3&@~$r$J$/$9$K$O6u$K$7$^$9(B",

		// Insert Link
		"Insert/Modify Link"                                : "Insert/Modify Link",
		"None (use implicit)"                               : "$B$J$7(B (use implicit)",
		"New window (_blank)"                               : "$B?75,%&%#%s%I%&(B (_blank)",
		"Same frame (_self)"                                : "$BF1$8%U%l!<%`(B (_self)",
		"Top frame (_top)"                                  : "$B>e$N%U%l!<%`(B (_top)",
		"Other"                                             : "$B$=$NB>(B",
		"Target:"                                           : "$BBP>](B:",
		"Title (tooltip):"                                  : "$BBjL>(B ($B%D!<%k%A%C%W(B):",
		"URL:"                                              : "URL:",
		"You must enter the URL where this link points to"  : "You must enter the URL where this link points to",
		// Insert Table
		"Insert Table"                                      : "$B%F!<%V%k$NA^F~(B",
		"Rows:"                                             : "$B9T(B:",
		"Number of rows"                                    : "$B9T?t(B",
		"Cols:"                                             : "$BNs(B:",
		"Number of columns"                                 : "$BNs?t(B",
		"Width:"                                            : "$BI}(B:",
		"Width of the table"                                : "$B%F!<%V%k$NI}(B",
		"Percent"                                           : "$B%Q!<%;%s%H(B",
		"Pixels"                                            : "$B%T%/%;%k(B",
		"Em"                                                : "Em",
		"Width unit"                                        : "$BI}$NC10L(B",
		"Positioning of this table"                         : "$B$3$N%F!<%V%k$N0LCV(B",
		"Cell spacing:"                                     : "$B%;%k$N4V3V(B:",
		"Space between adjacent cells"                      : "$BNY@\$7$?%;%k$N4V3V(B",
		"Cell padding:"                                     : "$B%;%k$N7d4V(B:",
		"Space between content and border in cell"          : "$B%;%k$N6-3&@~$HFbMF$N4V3V(B",
		// Insert Image
		"Insert Image"                                      : "$B2hA|$NA^F~(B",
		"Image URL:"                                        : "$B2hA|(B URL:",
		"Enter the image URL here"                          : "$B$3$3$K2hA|$N(B URL $B$rF~NO(B",
		"Preview"                                           : "$B%W%l%S%e!<(B",
		"Preview the image in a new window"                 : "$B?75,%&%#%s%I%&$G2hA|$r%W%l%S%e!<(B",
		"Alternate text:"                                   : "$BBeMQ%F%-%9%H(B:",
		"For browsers that don't support images"            : "$B2hA|$r%5%]!<%H$7$J$$%V%i%&%6!<$N$?$a$K(B",
		"Positioning of this image"                         : "$B$3$N2hA|$N0LCV(B",
		"Image Preview:"                                    : "$B2hA|$N%W%l%S%e!<(B:"
	}
};
