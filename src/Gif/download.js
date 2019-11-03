var casper = require("casper").create({
    verbose: true,
    logLevel: "debug",
    timeout: 10000,
    pageSettings: {
        javascriptEnabled: true,
        userAgent: "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"
    }
});

casper.start("https://giphy.com/search/animal-crossing/9?is=1&json=true", function() {
    this.echo(this.getTitle());
    this.download("https://i.giphy.com/media/QrrEOFRy0SbNC/giphy.gif", "categories9.gif");
});

casper.run();
