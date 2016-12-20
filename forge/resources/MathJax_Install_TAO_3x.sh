#!/bin/bash

# MathJax_Install_TAO_3x.sh
# Changes:
# - Add standard compatibility for OS X (falls back to curl instead of wget).
# - Switch to non-interactive mode usage. By default, MathJax install in TAO is shrinked. Use flag --keep-full to keep all MathJax archive content extracted.
# - Don't extract all archive content then eventually remove unused folders; instead, exclude from extraction.
# - Temp folder is removed, including when execution is interrupted.

# Trap ctrl-c and call ctrl_c()
trap ctrl_c INT

function ctrl_c() {
	rm -rf $TMPDIR
	echo ""
	echo "Execution aborted. Temporary download folder removed."
	
	exit 1
}

MATHJAX_MAJMINVERSION=2.6.1
MATHJAX_URL=https://github.com/mathjax/MathJax/archive/${MATHJAX_MAJMINVERSION}.tar.gz
FILENAME=mathjax.tar.gz
TMPDIR=$( mktemp -d tmp_mathjax_XXXXX)
DLFILE="$TMPDIR/$FILENAME"
WGET_OR_CURL=wget
MATHJAXPATH=taoQtiItem/views/js/mathjax

# Check wget binary or fallback with curl
if [ "$( which wget )" = "" ]; then

	WGET_OR_CURL=curl
	if [ "$( which $WGET_OR_CURL )" = "" ]; then
		echo "wget or at least curl binary is required to download MathJax. Please install one of these."
		exit 1
	fi
fi

# Check TAO path
if [ ! -d "./tao" ] ; then
#|| [ ! -d "./$MATHJAXPATH/.." ]; then
	echo "Please run this script at the root of TAO."
	exit 0
fi

if [ ! -d "./$MATHJAXPATH" ]; then
        echo -n "The 'mathjax' subfolder is missing. Attempt to create one... "
        mkdir $MATHJAXPATH

	if [ ! -d "./$MATHJAXPATH" ]; then
		echo
	        echo "The 'mathjax' subfolder could not be created. Please check write permissions on that path."
	        exit 0
	fi
	echo "success!"
fi

if [ ! -w "$MATHJAXPATH" ]; then
	echo "$MATHJAXPATH is not writable, please apply sufficient permissions and retry."
	exit 0
fi

echo ""
echo "Start downloading MathJax into TAO"
echo ""

if [ "$WGET_OR_CURL" = "wget" ]; then
	wget --output-document="${DLFILE}" "${MATHJAX_URL}"
else
	if [ "$WGET_OR_CURL" = "curl" ]; then
		curl -L -o "${DLFILE}" -O "${MATHJAX_URL}"
		echo ""
	fi
fi

# Cleanup before extraction
rm -rf $MATHJAXPATH/*

# Extraction

if [ "$1" != "--keep-full" ]; then

cat <<EOF > ${TMPDIR}/exclude.txt
docs
test
unpacked
config/local
config/A*
config/M*
config/Safe.js
config/default.js
config/TeX-AMS-MML_HTMLorMML.js
config/TeX-AMS-MML_SVG*
config/TeX-AMS_HTML*
config/TeX-MML*
fonts/HTML-CSS/TeX/otf
fonts/HTML-CSS/TeX/svg
fonts/HTML-CSS/Asana-Math
fonts/HTML-CSS/Gyre-Pagella
fonts/HTML-CSS/Gyre-Termes
fonts/HTML-CSS/Latin-Modern
fonts/HTML-CSS/Neo-Euler
fonts/HTML-CSS/STIX-Web
EOF

	tar --strip-components=1 -xzf "${DLFILE}" -C "${MATHJAXPATH}" -X ${TMPDIR}/exclude.txt
else
	tar --strip-components=1 -xzf "${DLFILE}" -C "${MATHJAXPATH}"
fi

#remove local temp folder
rm -rf $TMPDIR

echo ""
echo "Enjoy MathML in TAO ;)"
echo ""
