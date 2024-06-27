var cardComments = document.getElementById('cardComments');
var commentsContent = document.getElementById('commentsContent');
var docDirection = document.getElementById('docDirection');
var docNumber = document.getElementById('docNumber');
var comments = document.getElementById('comments');
var dComment = document.getElementById('dComment');

hideElement(commentsContent);
showCardComments(1);

document.getElementById('blockSwitch').addEventListener('click', function() {
	if (commentsContent.style.display === 'block') {
		hideElement(commentsContent);
		this.title = 'Показати коментарі';
	}
	else {
		showElement(commentsContent, 'block');
		this.title = 'Сховати коментарі';
	}
});

document.getElementById('bt_addComment').addEventListener('click', function() {
	const data = {
		dComment: document.getElementById('dComment').value,
		docDirection: docDirection.value,
		docNumber: docNumber.value
	};

	sendCardComment(data);
});

function showCardComments (pageNumber) {
	const data = {
		docDirection: docDirection.value,
		docNumber: docNumber.value,
		pageNumber: pageNumber
	};

	sendPost(data, 'http://notes.petamicr.zzz.com.ua/df/get-card-comments', function(resp) {
		if (resp.errors) {
			for (let error of resp.errors) {
				showNotification(error);
			}
		}
		else {
			comments.innerHTML = '';

			for (let commentRow of resp.commentsData.comments) {
				console.log(commentRow);
				let newDiv = document.createElement('div');
				newDiv.textContent = commentRow.ccm_comment;
				let infoDiv = document.createElement('div');

				let datePart = commentRow.ccm_add_date.slice(0, 10).split('-').reverse().join('.');
				let timePart = commentRow.ccm_add_date.slice(11, 16);
				let formattedDt = datePart + ' ' + timePart;

				infoDiv.textContent = formattedDt + ' ' + commentRow.us_login;
				infoDiv.classList.add('comment-info');
				newDiv.insertBefore(infoDiv, newDiv.firstChild);
				newDiv.classList.add('comment-item');
				comments.insertBefore(newDiv, comments.firstChild);
			}
		}
	});
}

function sendCardComment (data) {
	sendPost(data, 'http://notes.petamicr.zzz.com.ua/df/card-add-comment', function(resp) {
		if (resp.errors) {
			for (let error of resp.errors) {
				showNotification(error);
			}
		}
		else {
			if (resp.result && (resp.result === true)) {
				showNotification('Коментар доданий');
				dComment.value = '';
				showCardComments(1);
			}
		}
	});
}
