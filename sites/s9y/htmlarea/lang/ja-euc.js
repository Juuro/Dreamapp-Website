// I18N constants -- Japanese EUC-JP

// LANG: "ja-euc", ENCODING: EUC-JP
// Author: Mihai Bazon, http://dynarch.com/mishoo
// Translator:  
//   Manabu Onoue <tmocsys@tmocsys.com>, 2004.
//   Tadashi Jokagi <elf2000@users.sourceforge.net>, 2005.

HTMLArea.I18N = {

	// the following should be the filename without .js extension
	// it will be used for automatically load plugin language.
	lang: "ja-euc",

	tooltips: {
		bold:           "����",
		italic:         "����",
		underline:      "����",
		strikethrough:  "�Ǥ��ä���",
		subscript:      "���դ�ź����",
		superscript:    "���դ�ź����",
		justifyleft:    "����",
		justifycenter:  "�����",
		justifyright:   "����",
		justifyfull:    "��������",
		orderedlist:    "�ֹ��դ��վ��",
		unorderedlist:  "�����դ��վ��",
		outdent:        "����ǥ�Ȳ��",
		indent:         "����ǥ������",
		forecolor:      "ʸ����",
		hilitecolor:      "�طʿ�",
		horizontalrule: "��ʿ��",
		createlink:     "��󥯺���",
		insertimage:    "��������",
		inserttable:    "�ơ��֥�����",
		htmlmode:       "HTMLɽ������",
		popupeditor:    "���ǥ�������",
		about:          "�С���������",
		showhelp:       "Help using editor",
		textindicator:  "���ߤΥ�������",
		undo:           "�Ǹ��������ä�",
		redo:           "�Ǹ��ư�����ľ��",
		cut:            "������ڤ���",
		copy:           "����򥳥ԡ�",
		paste:          "����åץܡ��ɤ���Ž���դ�",
		lefttoright:    "�����鱦������",
		righttoleft:    "�����麸������",
		removeformat:   "�񼰤������",
		print:          "�ɥ�����Ȥ����",
		killword:       "MSOffice �����������"
	},

	buttons: {
		"ok":           "OK",
		"cancel":       "���ä�"
	},

	msg: {
		"Path":         "�ѥ�",
		"TEXT_MODE":    "�ƥ����ȥ⡼�ɤǤ���[<>] �ܥ����Ȥä� WYSIWYG �����ޤ���",

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
		"Cancel"                                            : "���ä�",

		"Alignment:"                                        : "���ֹ�碌:",
		"Not set"                                           : "���ꤷ�ʤ�",
		"Left"                                              : "��",
		"Right"                                             : "��",
		"Texttop"                                           : "Texttop",
		"Absmiddle"                                         : "Absmiddle",
		"Baseline"                                          : "�١����饤��",
		"Absbottom"                                         : "Absbottom",
		"Bottom"                                            : "��",
		"Middle"                                            : "���",
		"Top"                                               : "��",

		"Layout"                                            : "�쥤������",
		"Spacing"                                           : "�ֳ�",
		"Horizontal:"                                       : "��ʿ:",
		"Horizontal padding"                                : "��ʿ�η��",
		"Vertical:"                                         : "��ľ:",
		"Vertical padding"                                  : "��ľ�η��",
		"Border thickness:"                                 : "������������:",
		"Leave empty for no border"                         : "��������ʤ����ˤ϶��ˤ��ޤ�",

		// Insert Link
		"Insert/Modify Link"                                : "Insert/Modify Link",
		"None (use implicit)"                               : "�ʤ� (use implicit)",
		"New window (_blank)"                               : "����������ɥ� (_blank)",
		"Same frame (_self)"                                : "Ʊ���ե졼�� (_self)",
		"Top frame (_top)"                                  : "��Υե졼�� (_top)",
		"Other"                                             : "����¾",
		"Target:"                                           : "�о�:",
		"Title (tooltip):"                                  : "��̾ (�ġ�����å�):",
		"URL:"                                              : "URL:",
		"You must enter the URL where this link points to"  : "You must enter the URL where this link points to",
		// Insert Table
		"Insert Table"                                      : "�ơ��֥������",
		"Rows:"                                             : "��:",
		"Number of rows"                                    : "�Կ�",
		"Cols:"                                             : "��:",
		"Number of columns"                                 : "���",
		"Width:"                                            : "��:",
		"Width of the table"                                : "�ơ��֥����",
		"Percent"                                           : "�ѡ������",
		"Pixels"                                            : "�ԥ�����",
		"Em"                                                : "Em",
		"Width unit"                                        : "����ñ��",
		"Positioning of this table"                         : "���Υơ��֥�ΰ���",
		"Cell spacing:"                                     : "����δֳ�:",
		"Space between adjacent cells"                      : "���ܤ�������δֳ�",
		"Cell padding:"                                     : "����η��:",
		"Space between content and border in cell"          : "����ζ����������Ƥδֳ�",
		// Insert Image
		"Insert Image"                                      : "����������",
		"Image URL:"                                        : "���� URL:",
		"Enter the image URL here"                          : "�����˲����� URL ������",
		"Preview"                                           : "�ץ�ӥ塼",
		"Preview the image in a new window"                 : "����������ɥ��ǲ�����ץ�ӥ塼",
		"Alternate text:"                                   : "���ѥƥ�����:",
		"For browsers that don't support images"            : "�����򥵥ݡ��Ȥ��ʤ��֥饦�����Τ����",
		"Positioning of this image"                         : "���β����ΰ���",
		"Image Preview:"                                    : "�����Υץ�ӥ塼:"
	}
};
