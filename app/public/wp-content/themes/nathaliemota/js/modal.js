document.addEventListener('DOMContentLoaded', function () {
    var boutonContact = document.getElementById('boutonContact');
    var popup = document.getElementById('popup');
    var span = document.getElementsByClassName('close')[0];

    boutonContact.onclick = function () {
        var reference = this.getAttribute('data-reference');
        fetchPhotos(reference);
    };

    span.onclick = function () {
        popup.style.display = 'none';
    };

    window.onclick = function (event) {
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    };

    function fetchPhotos(reference) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/wp-admin/admin-ajax.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 400) {
                var response = xhr.responseText;
                document.getElementById('popup-photos').innerHTML = response;
                popup.style.display = 'block';
            } else {
                console.error(xhr.responseText);
            }
        };
        xhr.send('action=get_photos_by_reference&reference=' + reference);
    }
});



