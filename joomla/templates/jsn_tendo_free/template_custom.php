<?php
$jsnutils	= JSNTplUtils::getInstance();
$doc		= $this->_document;

// Count module instances
$doc->hasRight		= $jsnutils->countModules('right');
$doc->hasLeft		= $jsnutils->countModules('left');
$doc->hasPromo		= $jsnutils->countModules('promo');
$doc->hasPromoLeft	= $jsnutils->countModules('promo-left');
$doc->hasPromoRight	= $jsnutils->countModules('promo-right');
$doc->hasInnerLeft	= $jsnutils->countModules('innerleft');
$doc->hasInnerRight	= $jsnutils->countModules('innerright');

// Define template colors
$doc->templateColors	= array('red', 'orange', 'cyan', 'green', 'yellow', 'pink');

if (isset($doc->sitetoolsColorsItems))
{
	$this->_document->templateColors = $doc->sitetoolsColorsItems;
}

// Apply K2 style
if ($jsnutils->checkK2())
{
	$doc->addStylesheet($doc->templateUrl . "/ext/k2/jsn_ext_k2.css");
}

$customCss	= '

.fullwidth {
	width: 100% !important;
}

';

// Process TPLFW v2 parameter
if (isset($doc->customWidth))
{
	if ($doc->customWidth != 'responsive')
	{
		$customCss .= '
	#jsn-page {
		min-width: ' . $doc->customWidth . ';
	}
	#jsn-pos-topbar,
	#jsn-header,
	#jsn-menu_inner1,
	#jsn-content-top,
	#jsn-content-bottom,
	#jsn-content,
	#jsn-promo,
	#jsn-pos-content-top,
	#jsn-pos-content-bottom,
	.why-choose,
	.counting-stat,
	.ready-purchase,
	#demo-aboutus-inner,
	#jsn-article,
	#jsn-footer {
		width: ' . $doc->customWidth . ';
		margin: 0 auto;
	}';
	}
}

$doc->addStyleDeclaration(trim($customCss, "\n"));
