(function() {
    const unixTimestamp = _ => {
        let timestamp = parseInt(this.innerHTML);
        var date = new Date(timestamp * 1000);
        var hours = date.getHours();
        var minutes = "0" + date.getMinutes();
        var seconds = "0" + date.getSeconds();
        var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
        this.innerHTML = formattedTime;
        //console.log(this.innerHTML);
    }
})();