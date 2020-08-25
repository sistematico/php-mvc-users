(function() {
    const unixTimestamp = (item) => {
        let timestamp = parseInt(item.innerHTML);
        var date = new Date(timestamp * 1000);
        var years = date.getFullYear();
        var months = "0" + (date.getMonth()+1);
        var days = "0" + (date.getDate()+1);
        var hours = "0" + date.getHours();
        var minutes = "0" + date.getMinutes();
        var seconds = "0" + date.getSeconds();
        var formattedTime = days.substr(-2) + '/' + months.substr(-2) + '/' + years + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        item.innerHTML = formattedTime;
    }

    var timestamps = document.getElementsByClassName("ts");
    for (var i = 0; i < timestamps.length; i++) {
        unixTimestamp(timestamps[i]);
    }
})();