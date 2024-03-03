var mdocotion_add_header = (image_url) => {
	const contentView = document.querySelector(".mdocotion-content-view");

	const headerViewElem = document.createElement("div");
	headerViewElem.classList.add("mdocotion-header-view");
	headerViewElem.innerHTML = '<img src="' + image_url + '" />';

	contentView.insertBefore(headerViewElem, contentView.firstChild);
};

var changeCodeHighlightMaxWidth = (codeHightlights) => {
	contentWidth = innerDimensions(document.querySelector(".mdocotion-content-block-inner")).width;
	codeHightlights.forEach((codeHightlight) => {
		codeHightlight.style.maxWidth = contentWidth + "px";
	});
};

var innerDimensions = (node) => {
	var computedStyle = getComputedStyle(node)

	let width = node.clientWidth // width with padding
	let height = node.clientHeight // height with padding

	height -= parseFloat(computedStyle.paddingTop) + parseFloat(computedStyle.paddingBottom)
	width -= parseFloat(computedStyle.paddingLeft) + parseFloat(computedStyle.paddingRight)
	return { height, width }
};

window.onload = () => {
	if (window.location.hash == "#hide-navigation") {
		// Hide navigation
		document.querySelector(".md-sidebar--primary").style.display = "none";
		// Hide navigation button for mobile
		document.querySelector(".md-header .header-inner .header-info-bar label[for='__drawer']").style.display = "none";
		// Hide search
		document.querySelector(".md-header .header-inner .mdocotion-header-nav .md-search").style.display = "none";
		// Hide search button for mobile
		document.querySelector(".md-header .header-inner .mdocotion-header-nav label[for='__search']").style.display = "none";

		// Remove padding top from content block if there is no header image
		if (!document.querySelector(".mdocotion-header-view")) {
			document.querySelector(".mdocotion-content-block").style.paddingTop = "0";
		}
	}

	const codeHightlights = document.querySelectorAll(".mdocotion-content-view .highlight");
	if (codeHightlights.length > 0) {
		window.addEventListener('resize', function(event) {
			changeCodeHighlightMaxWidth(codeHightlights);
		});
		changeCodeHighlightMaxWidth(codeHightlights);	
	}
};
