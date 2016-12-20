#!/bin/bash

# PDFJS_Install_TAO_3x.sh
# Changes:
# - creation

# Trap ctrl-c and call ctrl_c()
trap ctrl_c INT

function ctrl_c() {
	rm -rf $TMPDIR
	echo ""
	echo "Execution aborted. Temporary download folder removed."
	
	exit 1
}

PDFJS_MAJMINVERSION=1.4.20
PDFJS_URL=https://github.com/mozilla/pdf.js/releases/download/v${PDFJS_MAJMINVERSION}/pdfjs-${PDFJS_MAJMINVERSION}-dist.zip
PDFJS_SOURCES=https://github.com/mozilla/pdf.js/archive/v${PDFJS_MAJMINVERSION}.tar.gz
FILENAME=pdfjs.tar.gz
TMPDIR=$( mktemp -d tmp_pdfjs_XXXXX)
DLFILE="$TMPDIR/$FILENAME"
WGET_OR_CURL=wget
PDFJSPATH=tao/views/js/lib/pdfjs

# Check wget binary or fallback with curl
if [ "$( which wget )" = "" ]; then

	WGET_OR_CURL=curl
	if [ "$( which $WGET_OR_CURL )" = "" ]; then
		echo "wget or at least curl binary is required to download PDF.js. Please install one of these."
		exit 1
	fi
fi

# Check TAO path
if [ ! -d "./tao" ] ; then
#|| [ ! -d "./$PDFJSPATH/.." ]; then
	echo "Please run this script at the root of TAO."
	exit 0
fi

if [ ! -d "./$PDFJSPATH" ]; then
        echo -n "The 'pdfjs' subfolder is missing. Attempt to create one... "
        mkdir $PDFJSPATH

	if [ ! -d "./$PDFJSPATH" ]; then
		echo
	        echo "The 'pdfjs' subfolder could not be created. Please check write permissions on that path."
	        exit 0
	fi
	echo "success!"
fi

if [ ! -w "$PDFJSPATH" ]; then
	echo "$PDFJSPATH is not writable, please apply sufficient permissions and retry."
	exit 0
fi

echo ""
echo "Start downloading PDF.js into TAO"
echo ""

if [ "$WGET_OR_CURL" = "wget" ]; then
	wget --output-document="${DLFILE}" "${PDFJS_URL}"
else
	if [ "$WGET_OR_CURL" = "curl" ]; then
		curl -L -o "${DLFILE}" -O "${PDFJS_URL}"
		echo ""
	fi
fi

# Cleanup before extraction
rm -rf $PDFJSPATH/*

# Extraction
unzip "${DLFILE}" -d "${PDFJSPATH}"

#remove local temp folder
rm -rf $TMPDIR

echo ""
echo "Enjoy PDF in TAO ;)"
echo ""
