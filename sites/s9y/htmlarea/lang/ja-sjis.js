// I18N constants -- Japanese SHIFT JIS

// LANG: "ja-sjis", ENCODING: SHIFT_JIS
// Author: Mihai Bazon, http://dynarch.com/mishoo
// Translator:  
//   Manabu Onoue <tmocsys@tmocsys.com>, 2004.
//   Tadashi Jokagi <elf2000@users.sourceforge.net>, 2005.

HTMLArea.I18N = {

	// the following should be the filename without .js extension
	// it will be used for automatically load plugin language.
	lang: "ja-sjis",

	tooltips: {
		bold:           "����",
		italic:         "�Α�",
		underline:      "����",
		strikethrough:  "�ł�������",
		subscript:      "���t���Y����",
		superscript:    "��t���Y����",
		justifyleft:    "����",
		justifycenter:  "������",
		justifyright:   "�E��",
		justifyfull:    "�ϓ����t",
		orderedlist:    "�ԍ��t���ӏ�����",
		unorderedlist:  "�L���t���ӏ�����",
		outdent:        "�C���f���g����",
		indent:         "�C���f���g�ݒ�",
		forecolor:      "�����F",
		hilitecolor:      "�w�i�F",
		horizontalrule: "������",
		createlink:     "�����N�쐬",
		insertimage:    "�摜�}��",
		inserttable:    "�e�[�u���}��",
		htmlmode:       "HTML�\���ؑ�",
		popupeditor:    "�G�f�B�^�g��",
		about:          "�o�[�W�������",
		showhelp:       "Help using editor",
		textindicator:  "���݂̃X�^�C��",
		undo:           "�Ō�̑����������",
		redo:           "�Ō�̓������蒼��",
		cut:            "�I����؂���",
		copy:           "�I�����R�s�[",
		paste:          "�N���b�v�{�[�h����\��t��",
		lefttoright:    "������E�̕���",
		righttoleft:    "�E���獶�̕���",
		removeformat:   "��������菜��",
		print:          "�h�L�������g�����",
		killword:       "MSOffice �^�O����菜��"
	},

	buttons: {
		"ok":           "OK",
		"cancel":       "������"
	},

	msg: {
		"Path":         "�p�X",
		"TEXT_MODE":    "�e�L�X�g���[�h�ł��B[<>] �{�^�����g���� WYSIWYG �ɖ߂�܂��B",

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
		"Cancel"                                            : "������",

		"Alignment:"                                        : "�ʒu���킹:",
		"Not set"                                           : "�ݒ肵�Ȃ�",
		"Left"                                              : "��",
		"Right"                                             : "�E",
		"Texttop"                                           : "Texttop",
		"Absmiddle"                                         : "Absmiddle",
		"Baseline"                                          : "�x�[�X���C��",
		"Absbottom"                                         : "Absbottom",
		"Bottom"                                            : "��",
		"Middle"                                            : "����",
		"Top"                                               : "��",

		"Layout"                                            : "���C�A�E�g",
		"Spacing"                                           : "�Ԋu",
		"Horizontal:"                                       : "����:",
		"Horizontal padding"                                : "�����̌���",
		"Vertical:"                                         : "����:",
		"Vertical padding"                                  : "�����̌���",
		"Border thickness:"                                 : "���E���̑���:",
		"Leave empty for no border"                         : "���E�����Ȃ����ɂ͋�ɂ��܂�",

		// Insert Link
		"Insert/Modify Link"                                : "Insert/Modify Link",
		"None (use implicit)"                               : "�Ȃ� (use implicit)",
		"New window (_blank)"                               : "�V�K�E�B���h�E (_blank)",
		"Same frame (_self)"                                : "�����t���[�� (_self)",
		"Top frame (_top)"                                  : "��̃t���[�� (_top)",
		"Other"                                             : "���̑�",
		"Target:"                                           : "�Ώ�:",
		"Title (tooltip):"                                  : "�薼 (�c�[���`�b�v):",
		"URL:"                                              : "URL:",
		"You must enter the URL where this link points to"  : "You must enter the URL where this link points to",
		// Insert Table
		"Insert Table"                                      : "�e�[�u���̑}��",
		"Rows:"                                             : "�s:",
		"Number of rows"                                    : "�s��",
		"Cols:"                                             : "��:",
		"Number of columns"                                 : "��",
		"Width:"                                            : "��:",
		"Width of the table"                                : "�e�[�u���̕�",
		"Percent"                                           : "�p�[�Z���g",
		"Pixels"                                            : "�s�N�Z��",
		"Em"                                                : "Em",
		"Width unit"                                        : "���̒P��",
		"Positioning of this table"                         : "���̃e�[�u���̈ʒu",
		"Cell spacing:"                                     : "�Z���̊Ԋu:",
		"Space between adjacent cells"                      : "�אڂ����Z���̊Ԋu",
		"Cell padding:"                                     : "�Z���̌���:",
		"Space between content and border in cell"          : "�Z���̋��E���Ɠ��e�̊Ԋu",
		// Insert Image
		"Insert Image"                                      : "�摜�̑}��",
		"Image URL:"                                        : "�摜 URL:",
		"Enter the image URL here"                          : "�����ɉ摜�� URL �����",
		"Preview"                                           : "�v���r���[",
		"Preview the image in a new window"                 : "�V�K�E�B���h�E�ŉ摜���v���r���[",
		"Alternate text:"                                   : "��p�e�L�X�g:",
		"For browsers that don't support images"            : "�摜���T�|�[�g���Ȃ��u���E�U�[�̂��߂�",
		"Positioning of this image"                         : "���̉摜�̈ʒu",
		"Image Preview:"                                    : "�摜�̃v���r���[:"
	}
};
