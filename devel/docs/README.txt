Okey; so now you've got the thing working? I hope so!





This software is still a very pre-pre-pre-pre RC-release, so you should presumable not 
use it if you are not an experienced PHP-coder. 
The readme/install-instructions are not finished 
(when they're finished, we're probably up to a 1.0-release)



I hope you've at least looked at license/install.txt ?
Here we go:
::: Customising the appearence of the system :::

*WARNING*
The way the system handles designs have been changed; instead of changing on style/[top|bottom|menu|style]; change it in style/default/*
If you would like to have multiple designs, create a copy of default, and change the contents of that copy.

Remember that "default" is the design every new user gets, and anonymous users. If you do not enable users to change their theme in config/config.php; they will only be able to use default

*End warning, will change the rest of this text whenever I feel like it :P *

the folder style/ contains 


---top.php (first part of the pages)


---bottom.php (last part of the pages)


---menu.php (The menu)


---style.css (A css-file that is used on all pages [except seat-system])








If you would like to change the design of the system (something you should, since it's Laaknor that has created the default-design, and he is color-blind)


create the design, and put everything until "the page", or the dynamic content into top.php... If you have a text-based menu, you could probably use menu.php,


just change how each link is created in the function at the bottom of menu.php.





Put the rest of the design in bottom.php











No color-codes are (or should not be, might have happend, that's why we would like you to test this so that we could remove such mistakes) hardcoded into the system.


Everything should be in styles.css.... Change whatever is written here. The default design has used a lot of color-codes, so that you can see what is changeable.





::: Customising the appearence of the seatmap :::





Edit config/seat.css :)





::: Adding static pages :::


Add a file with the name you want for it in static/, you should probably try to avoid spaces and special characters.


The page will automagically come up in the menu if you use the default menu.php.


If you want the link-text to have a space in it, use a _ in the filename....





chmod the file so that it can be written to by the webserver. Edit it from the admin-menu.











::: If you...... :::





- Want to help, report a bug or [insert what you want here] - we have put up a forum [in norwegian] on [CHANGEME] (don't you thing I should write it? :P )





- Have code we should put into here: <a href=mailto:laaknor@globelan.net>mail Laaknor</a> =)





- Have a better name for it.... just contact us :)





- Wonder why it's called GlobeLAN DEVEL: It's because it is the development-version of the website of GlobeLAN :P *we lack a better name*





- Wish to contact us: laaknor@globelan.net && cronoman@globelan.net :)
