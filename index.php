<?php ?>
<html>
<head>
    <title>Pokemon Map from Twitter</title>
    <style>
        body { width: 800px; }
    </style>
</head>

<body>
<h1>History</h1>
<p>
I taught a short 5 week web programming class in the summer of 2016. The students
were taught basic PHP, MySQL, Google Maps, and Google Charts. In preparing the
material, I came up with various demo Google maps with fake data.
</p>

<p>
I will be teaching the class again, but this time I will have more interesting Google
Maps. Rather than using fake data again, I lots of real Pokemon data sourced from Twitter. 
Hopefully this time the students will be more engaged and will see the immediate usefulness
of what they are being taught.</p>

<h2>Versions</h2>
<ul>
    <li><p>v1.0 - The first version was just a proof of concept, and thus loading speed was 
    not important. This version called the Twitter API everytime the map page was reloaded. 
    The retrieved data was parsed and a json string was output. The first version went well, 
    and at the time 6s seemed liked an ok load time for mapping the data from 20 feeds.</p>
    <p>This version had icons for each pokemon. Clicking on the icon gave the name, stats,
     expiration time, and a map link.</p></li>
    
    <li><p>v2.0 - Calling the Twitter API for each page load was wasteful. If many people load
    the maps, then that would also quickly eat into the allowed quota. So, this next version
    introduced MySQL into the mix. Most of the code from v1 was repurposed for a page that
    would be run every minute from a Cron job. The code basically called the Twitter API and 
    saved the data in MySQL.</p>
    <p>This version queried the database on each page load. The query was fast, and it could 
    be faster if I indexed the tables. Minor revisions included adding color to the expiration 
    time to indicate time left. A link was also added for iPhone users to get Apple Map directions.</p>
    <p>Load time was around 2.5s, which is a HUGE speed difference from 6s.</li>
    
    <li><p>v3.0 - Rather than loading an icon for each pokemon, I wanted to see if loading a 
    sprite image would be faster. Using InstantSprite (https://instantsprite.com/), I was able to 
    combine all the 248 images into one large image file. Minor tweaks were made to some images so 
    that they were all a uniform 50 pixels tall so that the Google Map code could draw the icons. This 
    was much cleaner than having a style sheet with 248 separate styles.</p>
    <p>This version isn't noticeably faster than loading separate images. The long vertical image is 
    around 500k. It would probably be faster if I could figure out a way to have a smaller sprite image(s) 
    that didn't include every single pokemon.</p></li>
    
    <li><p>V4.0 - This version write the data to MySQL as usual, but it also POSTS the data to myjson.com. 
    Rather than hitting my server, I thought it'd be friendlier to my server to have the json data served
    from a separate server. Times still in the 2s range.</p>
    <p>This version has colored circles under the icons to quickly indicate how time is left.</li>
    
    <li><p>V5.0 - To shorten load time, pure text is being used rather than using images. Also, colored 
    markers are used rather than colored circles. Time did not go down; still in the 2s range. Server
     resources are minimal since a lot is client side with the javascript.</p></li>

    <li><p>Future versions ... maybe find some non official images to use instead of the text since the
     text version isn't faster. Images would be hosted on a CDN server. </p></li>
</ul>

</html>
</body>