Tag Cloud User Guide
Created by Cameron Abma
Currently located at http://192.168.168.110:8001/tagcloud.php

How to Use/General Info:
- The form should mostly be self explanatory but basically fill out the specific channels, start time, and duration to create your desired tag cloud.
- Once you have created a cloud you can change it by resubmitting the form, each submit will reshuffle the words in the cloud.
- Inorder to save the cloud as an image press either "conver current graph to png" or "convert current graph to jpeg" this will open up a new pop-up window (make sure pop ups aren't disabled on your browser) which holds only the image, which you can then drag on to your desktop or right click and save.
- Advanced settings size scale of the words in the cloud, minimum frequency of a word for it to be in the cloud, extra stop words, and color of the graph can all be found by clicking the "Advanced settings" button

The program uses d3.js (comes in a whole folder) and d3.layout.cloud.js inorder to draw the cloud and rotate the letters. 
The program uses html2canvas.js and html2canvas.svg.js inorder to save the cloud as an png or jpeg file.

-If there are any questions or comments email me at chabma@gmail.com