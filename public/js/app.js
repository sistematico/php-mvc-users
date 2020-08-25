(function() {
    var timestamps = document.getElementsByClassName("ts");
    for (var i = 0; i < timestamps.length; i++) {
        timestamps[i].innerHTML = 'Olá';
    }

    const unixTimestamp = (obj) => {
        let timestamp = parseInt(obj.innerHTML);
        var date = new Date(timestamp * 1000);
        var hours = date.getHours();
        var minutes = "0" + date.getMinutes();
        var seconds = "0" + date.getSeconds();
        var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        obj.innerHTML = formattedTime;
        console.log(formattedTime);
    }
})();