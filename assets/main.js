;(function() {
    var body = document.querySelector('body'); 
    var courseItem = document.querySelector('.course');   
    var closestItemByClass = function (item, className) {
        var node = item;
        while (node) {
            if (node.classList.contains(className)) {
                return node;
            }
            node = node.parentElement;
        }
        return null;
    };
    var showWindow = function (target) {
        target.classList.add('is_active');
    }
    var closeWindow = function (target) {
        target.classList.remove('is_active');
    }
    
    body.addEventListener('click', function (e) { 
        var target = e.target;
        var course = closestItemByClass(target, 'header_start_course');
        if (course !== null) {
            if (courseItem.classList.contains('is_active')) { closeWindow(courseItem); }
            else { showWindow(courseItem); }
        } 
    });

    body.addEventListener('dblclick', function (e) { 
        var target = e.target;
        var elem = closestItemByClass(target, 'files_middle_block');
        if (elem !== null) {            
            //const fileId = elem.getAttribute('data-id');
            //window.location.href = `view.php?id=${fileId}`;

            const fileId = elem.getAttribute('data-id');
            // Здесь вы должны указать правильный путь к файлу
            window.open(`view.php?id=${fileId}`, '_blank'); // Открыть в новой вкладке
        } 
    });

    var sort = document.getElementById('sortSelect');
    sort.addEventListener('change', function() {
        const sortBy = sort.value;
        window.location.href = `index.php?sort=${sortBy}`;
        console.log(sortBy);
        
    });

    var upload = document.getElementById('uploadButton');
    upload.addEventListener('click', function() {
        document.getElementById('fileInput').click();        
    });

    var input = document.getElementById('fileInput');
    input.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('file', file);
    
            fetch('database.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    window.location.reload(); 
                } else {
                    alert('Ошибка загрузки файла.');
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        }
    });
    
})();