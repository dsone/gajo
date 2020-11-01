import Ajax from './components/Ajax';
import Pending from './components/Pending';
import Options from './components/options/Options';

// Init Options
let options = new Options({
	privateProfile:	$('.js-options-privateProfile'),
	colorblind:		$('.js-options-colorblind'),
	hideReleased:	$('.js-options-hideReleased'),
	hideTBA:		$('.js-options-hideTBA'),
	rss:			$('.js-options-rss'),
	changeRSS:		$('.js-btn-rss'),
	ajax:			Ajax,
	pending:		Pending,
});

require('./funcs/types');