#!/bin/sh

MATHJAX_URL=https://github.com/mathjax/MathJax/archive/2.2.0.tar.gz
TMPDIR=$( mktemp -d tmp_mathjax_XXXXX)
FILENAME=mathjax.tar.gz
DLFILE="$TMPDIR/$FILENAME"
CURRENT=$( pwd )
MATHJAXPATH=taoQtiItem/views/js/mathjax

#Check wget 
if [ $( which wget ) = "" ] ; then
	echo "Wget is required to download MathJax"
	exit 0
fi

#Check TAO path
if [ !  -d "./tao" ] || [ ! -d "$MATHJAXPATH" ] ; then
	echo "Please run me into the root of a TAO distribution"
	exit 0
fi
if [ ! -w "$MATHJAXPATH" ]; then
	echo "$MATHJAXPATH is not writable, please advice."
	exit 0
fi


echo ""
echo "Start Downloading MathJax into TAO"
echo ""

wget --output-document="${DLFILE}"  "${MATHJAX_URL}"

tar --strip-components=1 -xzf "${DLFILE}" -C "${MATHJAXPATH}"

if [ -d "$MATHJAXPATH/jax" ]; then

	#remove unused directory  
	echo ""
	read -p "Removing unused MathJax content ( call 'rm -rf' from $MATHJAXPATH) ? [Y/N]: " yn
	if [ "$yn" = "Y" ] || [ "$yn" = "y" ]; then
		echo "removing unused content..."
		rm -rf "$MATHJAXPATH/docs"
		rm -rf "$MATHJAXPATH/test"
		rm -rf "$MATHJAXPATH/unpacked"
		rm -rf "$MATHJAXPATH/config/local"
		rm -f "$MATHJAXPATH/config/A"*
		rm -f "$MATHJAXPATH/config/M"*
		rm -f "$MATHJAXPATH/config/Safe.js"
		rm -f "$MATHJAXPATH/config/default.js"
		rm -f "$MATHJAXPATH/config/TeX-AMS-MML_HTMLorMML.js"
		rm -f "$MATHJAXPATH/config/TeX-AMS-MML_SVG"*
		rm -f "$MATHJAXPATH/config/TeX-AMS_HTML"*
		rm -f "$MATHJAXPATH/config/TeX-MML"*
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/TeX/otf"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/TeX/png"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/TeX/svg"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/Asana-Math"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/Gyre-Pagella"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/Gyre-Termes"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/Latin-Modern"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/Neo-Euler"
		rm -rf "$MATHJAXPATH/fonts/HTML-CSS/STIX-Web"
		echo "done!"
	fi

	echo ""
	echo "Enjoy MathML in TAO ;)"
	echo ""

	exit 1
else
	echo ""
	echo "Oops something goes wrong, try"
	echo ""

fi
