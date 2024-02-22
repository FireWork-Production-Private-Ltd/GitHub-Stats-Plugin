# Screen Time Theme

This website showcases movies and their related information. On the homepage, you'll find a slider for slider movies, and Display cards of popular and top-rated movies. There are single pages for movies and people, which provide detailed information about each category. Additionally, there are archive pages for movies and people that display all posts related to each category.

# Created Home page

- Header
- Footer
- Homepage
- Featured Movies
- Upcoming Movie
- Trending Movie
- index.php

## Implemented Archive pages

- Movie Archive page
    - Title
    - Poster Image
    - Basic Metadata
    - Release Date
    - Rating

- Person Archive page
    - Profile Picture
    - Name
    - Birth Date
    - About Person

## Implemented Single pages

- Movie Single page
    - Title
    - Post Image
    - Synopsis
    - Basic Metadata
    - Content
    - Crew Information
    - Photo Gallery
    - Video Gallery
    - Comments

- Person Single page
    - Name
    - Profile Picture
    - Birth Date & Place
    - Social Information
    - About Person
    - Photo Gallery
    - Video Gallery

## Added Customizer Options

- Background Color
   - Controls the background color of the pages
- Display Navigation
   - Controls whether the navigation (previous post, next post) is visible or hidden
- Time Format
   - Controls the format for movie duration (e.g. HH:MM, minutes)
- Separator
   - Controls the separator character on the page (e.g. '-', '•')
- Sidebar Width
   - Controls the width of sidebar (in px, %, or other measurements)
- Featured Image Size
   - Controls the height and width of the poster/profile picture
   
## Added Widget for Related Movie on Movie Single page.
- It will display cards of movie before footer section.
   - Title - To display a title for the section. For example, Related Movies, Movie Recommendations
   - Count - To display the total number of movies. Default it to 3.
   - Relation criteria dropdown - The basis on which the relationship should be established. Options - custom taxonomies available like label or genre, etc.

## Added Widget for Celebrity Recommendation on Person Single page.
- It will display cards of Peron before footer section.
   - Title - To display a title for the section.
   - Count - To display the total number of persons. Default it to 4.
   - Relation criteria dropdown - The basis on which the relationship should be established. Options - custom taxonomies available like person's career, etc.

# Folder Structure
.
├── assets (dir)/
│   ├── css (dir)
│   ├── images (dir)
│   └── js (dir)
├── includes (dir)/
│   ├── class-movie-widget.php
│   ├── class-person-widget.php
│   ├── class-walker-social-menu.php
│   └── class-customizer-options.php
├── template-parts (dir)/
│   ├── header (dir)
│   ├── movie (dir)
│   ├── person (dir)
│   ├── post (dir)
│   ├── snapshot-gallery.php
│   ├── synopsis-container.php
│   └── video-gallery.php
├── archive-rt-movie.php
├── archive-rt-person.php
├── comments.php
├── footer.php
├── 404.php
├── functions.php
├── header.php
├── home.php
├── index.php
├── README.txt
├── screenshot.png
├── single-rt-movie.php
├── single-rt-person.php
└── style.css
