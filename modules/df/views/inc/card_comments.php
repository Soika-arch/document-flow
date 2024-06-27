<?php

// Вид включення коментарів до картки документа.

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$url = url('/df');

e('<div id="cardComments" class="fm">');

	e('<div class="comments-menu-1">');
		e('<span id="blockSwitch" class="img-btn" title="Показати коментарі"><img src="'.
			url('/img/comments_1.png') .'"></span>');
	e('</div>');

	e('<div id="commentsContent">');

		e('<form id="fmAddCardComment" class="fm_ad-card-comment" enctype="multipart/form-data"'.
			' name="fm_addIncomingDocument" method="post">');

			e('<div class="label_block">');
				e('<label for="dComment">Коментар</label>');
				e('<textarea id="dComment" type="date" name="dComment" required></textarea>');
			e('</div>');

			e('<input id="docDirection" type="hidden" name="docDirection" value="'.
				$Doc->displayedNumberPrefix .'">');

			e('<input id="docNumber" type="hidden" name="docNumber" value="'. $Doc->_number .'">');

			e('<div class="bt_add">');
				e('<button id="bt_addComment" type="button" name="bt_addComment">Додати</button>');
			e('</div>');

		e('</form>');

		e('<div id="comments" class="doc-card-comments"></div>');

	e('</div>');

e('</div>');

e('<script src="/js/df_document_card.js"></script>');

require $this->getViewFile('/inc/footer');
