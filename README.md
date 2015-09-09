## About

This plugin does only one thing: it allows you to prerender specific pages / posts on your WordPress site.

The [prerendering](https://developers.google.com/chrome/whitepapers/prerender) feature which will make your website faster, as the browser will fetch and render the entire next page on the background.

Therefore, if you know which page your visitors are most likely to visit next, you can preload it. The User Experience (UX) will therefore be slightly better.

### Getting Started

1. Firstly, you need to determine how your users traverse and interact with your site. Simply [sign in to Google Analytics](https://www.google.com/analytics/web/#home/) and go to the Behavior Flow page ([Analytics Help](https://support.google.com/analytics/answer/2785577?hl=en)).
2. Login to your WordPress site, install and activate this plugin.
3. Edit the page where most visitors land (*most likely your homepage*).
4. Scroll down to the meta box "Page to Prerender" and select the next page from the dropdown menu (the one that most visitors will browse next).
5. Hit the "Update" button!

### Cons

Enabling page prerendering will likely increase server load. You should figure out a good balance between prerendering and increasing the server load. Visitors that land on your site will request the entire next page even if they do not visit it...
