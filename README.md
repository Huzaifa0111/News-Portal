# News Portal - Client Management System

Introducing News Portal - the ultimate content management system built specifically for news websites! Whether you're a journalist or editor, this powerful platform offers an intuitive and user-friendly interface that makes creating, managing, and publishing news articles, photos, and videos an absolute breeze.

With its highly customizable and scalable design, News Portal offers a responsive layout that ensures your website looks stunning on any device. And the best part? You get all the features you need to deliver top-quality news to your audience, without any fuss or hassle.

Some of the standout features of News Portal include an easy-to-use interface for content creation and management, support for multimedia content such as photos and videos, search functionality that makes it easy for users to find specific articles, categories and tags to help organize content, social media integration for effortless sharing on various platforms, and SEO optimization to boost your search engine rankings.

At News Portal, our mission is to provide news organizations with a reliable, flexible, and user-friendly CMS that enables them to deliver high-quality content to their readers. And we're committed to continuously improving the platform and adding new features to meet the ever-evolving needs of the industry.

So, whether you're a seasoned pro or just starting out, News Portal has everything you need to create and deliver exceptional news content to your audience. And with our open-source model, you can contribute to the project on GitHub and be a part of shaping the future of news. Join us today and let's build the future of news together!


# Why?
●	In the modern world, news is now delivered through online portals that serve as a medium between the authors and the readers.
●	The Internet holds a huge advantage in the fact that it makes it easier to deal with constantly changing data.
●	However, this also comes with a huge caveat that the reader has no knowledge of recent changes in a news article.
●	We intend to offer a simple solution for this with our news portal software.


# How?
●	News Portal is written with PHP, HTML, CSS and relies on MySQL.
●	It has:
-	Clean and responsive website layout using Bootstrap 5 on the user-end and Bootstrap 3 on admin interface.
-	jQuery-based Search implementation for searching through the posts.
-	Posting with the capability to edit, remove, etc.
-	Commenting with moderation abilities and a neat UI.
-	Editing Transparency (explained later on)


# Posts
●	Posts are the news articles that are intended to be published.
●	They will have a title, a feature image, details as rich text, a category and a subcategory.
●	These posts are chronologically ordered and can be updated or deleted even after submission.
●	Deleted posts go into Trash, from where they can be either restored or permanently deleted.


# Posts: Implementation details
●	Every post has a unique post id and is stored in the SQL database in table *tblposts* with their relevant details. The feature image is then stored on disk.
●	The foreign keys *CategoryId* and *SubCategoryId* are present.
●	These post ids are also used as foreign keys in the comments table (*tblcomments*).
●	On the user-end, these are displayed in a Bootstrap Card layout as title, image and then, description.


# Posts: Admin
![Posts: Admin ](https://user-images.githubusercontent.com/87111556/230735737-65307a49-c8cf-4d5b-81b3-f343cfeec3c1.png)


# Posts: User-end (home page)
![sample_2](https://user-images.githubusercontent.com/87111556/230735754-97434ea5-ae8f-45ad-8515-34fa8a46308d.png)


# Posts: User-end (article) screenshot
![Posts: User-end (article)](https://user-images.githubusercontent.com/87111556/230735834-5b869c0d-8e13-4e23-a271-cd3a8f5252f2.png)


# Post Editing Transparency
●	Even when an administrator edits a post, the original remains in the database.
●	The reader can always see when an article was last updated.
●	In addition, if needed, the reader can view what were the changes made to the article since the original posting.
●	This prevents occurrences where the article has changed unexpectedly and allows transparency between the author and the reader.


# Post Editing Transparency: Implementation details
●	When a post is added, two copies of the same text is stored in the database. One as the original text and the other as the current text.
●	When a post is edited, the current text is the only field modified.
●	After editing of the post, the current text and the original text will differ.
●	The difference between them is then computed and displayed on- screen using htmldiff and then prettified by CSS.


# Post Editing Transparency: Screenshots
![Post Editing Transparency](https://user-images.githubusercontent.com/87111556/230735858-8b7be02c-7c61-4a1b-85d8-e2355b878164.png)

![Post Editing Transparency:](https://user-images.githubusercontent.com/87111556/230735890-47c943b0-7513-404b-bb97-8b6ca66e4194.png)

# Comments System
●	Readers are allowed to comment on each posts.
●	There is an approval system where a moderator or admin has to approve a comment for it to be publicly visible.
●	Comments can be made with just a name and e-mail address with no external logins.
●	Approved comments can also later be disapproved in case something goes wrong.


# Comments System: Implementation details
●	Every comment is stored in the tblcomments table of the database.
●	Each comment has a foreign key postId which connects it to the original post it belongs to.
●	When a post is deleted, related comments are also deleted due to implementation of recursive deletion.
●	There is a status flag that determines whether or not a comment is approved and to be displayed.
●	Bootstrap Cards are used to display comments if status is 1.


# Comments System: User-end
![Comments System: User-end](https://user-images.githubusercontent.com/87111556/230735921-d38d0ab0-6adf-4577-9dac-414821aad014.png)


# Comments System: Admin-end
![Comments System: Admin-end](https://user-images.githubusercontent.com/87111556/230735960-7dc956ca-bdcb-40e0-a372-a74e042f9007.png)


# Categories
●	News can be organized into categories and further into sub- categories.
●	The readers can filter news from one category.
●	The sub-category, on the other hand, is for internal organization and for giving an indication for the type of content present in an article.
●	Categories and sub-categories can be added or removed as the administrator pleases.


# Categories: Implementation details
●	Every post has a CategoryId and a SubCategoryId as foreign keys.
CategoryId is from the table tblcategory.
●	On the user-end, these categories can be used to filter content.
●	On the admin end, it is a powerful tool that can be used to delete or hide an entire set of posts, can be used for internal organization of data, etc.


# Categories: Admin-end 
![Categories: Admin-end](https://user-images.githubusercontent.com/87111556/230735987-822396c9-312d-42c9-9b74-3763a158142a.png)


# Pages
●	Pages are separate from the Posts feature.
●	They are used to present static content that will never change.
●	For example, “About Us” or “Contact Details” .
●	These pages do not have the post editing transparency feature and changes in them will not be tracked.
●	They support rich text and raw HTML input and in addition, can also make use of Bootstrap CSS. So, there’s a high level of flexibility.


# Pages: Implementation
●	Pages are stored in a separate table from posts called tblpages.
●	They have PageName, PageTitle, Description, PostingDate and UpdationDate. They have no comments, categories, etc.
●	They have a simple Breadcrumbs element on the top to indicate that it’s a page within the heirarchy but no other element besides the post title and description.
●	They’re also not part of the search results.
●	Pages are still adaptive but do not have boundary elements.


# Pages: User-end 
![Categories: Admin-end](https://user-images.githubusercontent.com/87111556/230736022-09751588-ca30-4521-8a97-94d3a0328d3e.png)


# Pages: Admin
![Categories: Admin-end](https://user-images.githubusercontent.com/87111556/230736045-23f59494-0b92-4c7a-b12b-5aeb51d48b7c.png)


# Admin Panel
●	The admin panel is where the administrator can make changes to the website and its contents.
●	The dashboard gives an overview of the current number of posts, categories, etc.
●	The rest of the panel allows access to all moderation, edition, submission and deletion features for posts, comments, pages and categories.


# Admin Panel: Dashboard
![Categories: Admin-end](https://user-images.githubusercontent.com/87111556/230736069-ad99a893-37f2-4111-a0e7-dbe3cbae1f1e.png)




