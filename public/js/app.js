(function() {
    const unixTimestamp = (item) => {
        let timestamp = parseInt(item.innerHTML);
        var date = new Date(timestamp * 1000);
        var years = date.getFullYear();
        var months = "0" + date.getMonth();
        var days = "0" + date.getDay();
        var hours = "0" + date.getHours();
        var minutes = "0" + date.getMinutes();
        var seconds = "0" + date.getSeconds();
        //var formattedTime = hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        var formattedTime = days.substr(-2) + '/' + months.substr(-2) + '/' + years + ' ' + hours.substr(-2) + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        item.innerHTML = formattedTime;
        //console.log(formattedTime);
    }

    var timestamps = document.getElementsByClassName("ts");
    for (var i = 0; i < timestamps.length; i++) {
        unixTimestamp(timestamps[i]);
    }
})();