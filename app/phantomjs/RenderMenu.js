/*
|--------------------------------------------------------------------------
| Render a webpage into an image file
|--------------------------------------------------------------------------
|
| This PhantomJS script loads a webpage and renders it into an image file.
| The usage is: phantomjs RenderMenu.js <source url> <target.jpeg>
|
*/

var page = require('webpage').create(),
    system = require('system'),
    url,
    file;

page.onError = function (msg, trace) {
    console.log(msg);
    trace.forEach(function(item) {
        console.log('  ', item.file, ':', item.line);
    })
}

if(system.args.length != 3) {
    console.log('Usage: RenderMenu.js url filename.jpeg');
    phantom.exit(1);
} else {
    url = system.args[1];
    file = system.args[2];

    // Render the image with a dynamic height and a fixed width of 1000 px
    page.viewportSize = { width: 1000 };
    page.open(url, function start(status) {
        if (status !== 'success') {
            console.log('Unable to load ' + url);
            phantom.exit(1);
        } else {
            // 200ms should be enough time to load all resources from localhost
            // TODO: maybe the magic number can be replaced by an OnLoadEvent?
            window.setTimeout(function () {
                page.render(file);
                phantom.exit();
            }, 200);
        }
    });
}