About Project
=============

Three .PHP files containing sample code that I have written for an online newspaper here in Saudi Arabia, called Al-Sharq. Due to the tight deadline and budget, the client specifically requested a customized WordPress theme, and wanted it to be as easy as possible to be updated. Therefore we decided to use Canvas as the base for the theme, which we heavily customized.

About the Files
===============

index-sample.php:
-----------------

The client required a dynamic area, at the top of the page, that would display specific stories, of his choosing. He then wanted two options:

* WordPress to automatically display three related stories, that match the selected story
* A custom text area where he could add his own content, such as text, images, hyperlinks etc.
* An additional custom text area where he could add a custom title (that is separate from the actual post title)

He basically wanted that area to be as customizable as possible, where he had the option go crazy and add as much custom content as he wanted, or let WordPress handle it, and simply select which story he wanted to display there.

So, this was a chance for me to really dig into taxonomies and custom fields

content-editorials-sample
-------------------------

The newspaper needed an editorial section. So I created a custom post type that was linkable to a taxonomy term that would serve as the editor's name. This way I could create a relationship between the editorials, and the editor's profile, through this taxonomy term. Additionally the taxonomy term could be used later for other queries.

The taxonomy term was also created, so that users would only have to enter an editor's name once, and then select it from a drop down menu in the back-end for each editorial that they wanted to assign it to. This was done to minimize error, and avoid duplicate editor names, with alternate spellings etc.

content-editor_profiles-sample
------------------------------
Each editor needed a profile page, that would contain a biography, as well as a list of all the editorials they have written. A custom post-type was set up, that was linked to the editor-name taxonomy term. This way the term could be used to link each editor profile page, to all of the editorials that had been assigned to the term.


Note
====

To distinguish the code that I have written, from Canvas's code, I have left the following comments to indicate where my code begins and ends:

* '//My Code Begins Here:' or '<!--My Code Begins Here: --> denotes where my code starts
* '//My Code Ends Here:' or '<!--My Code Ends Here--> denotes where my code ends
*  the fully functional website can be seen here: http://www.alsharq.net.sa/
* You will notice some Arabic text in the source code.

Why I'm proud of this project
=============================

This project gave me a chance to use WordPress custom taxonomies, post types and loops in fun and creative ways, that allowed me to step out of the typical blog format that I've used WordPress for, in the past. It also allowed me to develop for Arabic content, which is an opportunity I always welcome.