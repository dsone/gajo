import Ajax from './components/Ajax';
import Options from './components/Options';

let options = new Options({
	privateProfile:	$('.js-options-privateProfile'),
	colorblind:		$('.js-options-colorblind'),
	hideReleased:	$('.js-options-hideReleased'),
	hideTBA:		$('.js-options-hideTBA'),
	rss:			$('.js-options-rss'),
	changeRSS:		$('.js-btn-rss'),
	ajax:			Ajax,
});