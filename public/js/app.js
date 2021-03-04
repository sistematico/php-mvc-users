(function() {
    const unixTimestamp = (item) => {
        let timestamp = parseInt(item.innerHTML);
        if (typeof timestamp === 'number') {
            let date = new Date(timestamp * 1000);
            let years = date.getFullYear();
            let months = "0" + (date.getMonth() + 1);
            let days = "0" + (date.getDate() + 1);
            let hours = "0" + date.getHours();
            let minutes = "0" + date.getMinutes();
            let seconds = "0" + date.getSeconds();
            item.innerHTML = days.substr(-2) + '/' + months.substr(-2) + '/' + years + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        }
    }

    let timestamps = document.getElementsByClassName("ts");
    for (let i = 0; i < timestamps.length; i++) {
        unixTimestamp(timestamps[i]);
    }

    let toastElList = [].slice.call(document.querySelectorAll('.toast'))
    let toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl, { animation: true, autohide: true, delay: 10000 })
    })

    toastList.forEach(toast => toast.show())


    // Look for .hamburger
    var hamburger = document.querySelector(".hamburger");
    // On click
    hamburger.addEventListener("click", function() {
        // Toggle class "is-active"
        hamburger.classList.toggle("is-active");
        // Do something else, like open/close menu
    });
})();