(function() {
    const unixTimestamp = (item) => {
        let timestamp = parseInt(item.innerHTML);
        let date = new Date(timestamp * 1000);
        let years = date.getFullYear();
        let months = "0" + (date.getMonth()+1);
        let days = "0" + (date.getDate()+1);
        let hours = "0" + date.getHours();
        let minutes = "0" + date.getMinutes();
        let seconds = "0" + date.getSeconds();
        item.innerHTML = days.substr(-2) + '/' + months.substr(-2) + '/' + years + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
    }

    let timestamps = document.getElementsByClassName("ts");
    for (let i = 0; i < timestamps.length; i++) {
        unixTimestamp(timestamps[i]);
    }

    const toastOptions = { animation: true, autohide: true, delay: 5000 }
    let toastElList = [].slice.call(document.querySelectorAll('.toast'))
    let toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, toastOptions)
    })

    let result = '<?php echo isset($result) ? $result : ""; ?>';

    if (result !== '') {
        toastList.forEach(toast => toast.show())
    }
})();