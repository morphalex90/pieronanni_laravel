export const JobList = [
    {
        id: 6,
        title: 'Developer',
        company: {
            name: 'Cyber-Duck',
            url: 'https://www.cyber-duck.co.uk/',
        },
        location: 'London, UK',
        description: '<p>Managing daily tasks to resolve issues efficiently</p><p>Contributing to projects focused on refactoring platform sections</p>',
        description_cv: '<ul><li>Managing daily tasks to resolve issues efficiently</li><li>Contributing to projects focused on refactoring platform sections</li></ul>',
        start_date: '2024-01-08',
        end_date: null,
        projects: [
            {
                title: 'Worcester Bosch',
                url: 'https://www.worcester-bosch.co.uk',
                technologies: ['laravel', 'react'],
                description: '<p>United Kingdom based heating and hot water products manufacturer</p>',
                publish_date: '2024-04-12',
                images: ['worcesterbosch.webp']
            },
        ],
    },
    {
        id: 5,
        title: 'Lead Developer',
        company: {
            name: 'Soundpickr',
            url: 'https://www.soundpickr.com',
        },
        location: 'London, UK',
        description: '<p>Developed the main API, the main site, the user panel and the admin panel</p><p>Improved Google ranks and achieved 50% more users in the past 2 months</p>',
        description_cv: '<ul><li>Developed the API in Laravel and all the front-ends in Next.js / Vite with CI/CD</li><li>Implemented Spotify API and stored updated informations of around 7M artists</li><li>Built the song uploader that compressed to mp3 and uploaded to AWS S3 around 4k songs so far</li><li>Improved Google ranks and achieved 50% more users in the past 2 months</li></ul>',
        start_date: '2022-05-09',
        end_date: '2023-10-31',
        projects: [
            {
                title: 'Soundpickr',
                url: 'https://www.soundpickr.com',
                technologies: ['laravel', 'react'],
                description: '<p>Soundpickr has started as a small project for a friend, it then escalated to become a full scale big project where I was hired as the CTO</p><p>My knoledge of Laravel and React espanded quite significally thanks to this project</p><p>We structured it to have the main API in Laravel, that acts as the center of all and that is connected to all front-ends</p>',
                publish_date: '2020-04-12',
                images: ['soundpickr.webp']
            },
        ],
    },
    {
        id: 4,
        title: 'Web Developer',
        company: {
            name: 'Purr',
            url: 'https://purrgroup.com',
        },
        location: 'London, UK',
        description: '<p>Web Developer at PurrDigital</p><ul><li>Develop and publish the first Drupal 8 and 9 projects of the company</li><li>Optimize sites with best practices and from a code / security prospective</li></ul>',
        description_cv: '<ul><li>Optimised WP and Drupal sites with best practices and from a code and security prospective, converted to be composer based and deployed to Kinsta and Ploi with CI/CD</li><li>Created several tools to export and convert page content from old to new sites</li><li>Developed and published the first Drupal 8  project of the company to be a multisite with the possibility to easily add new sites</li></ul>',
        start_date: '2018-11-12',
        end_date: '2022-05-06',
        projects: [
            {
                title: 'Mathys & Squire - Scalehub Quarter',
                url: 'https://www.mathys-squire.com/scaleup-quarter/',
                technologies: ['wp'],
                description: '<p>The m&s Scalehub Quarter project was created by converting the main m&s WordPress website to be a multisite, as it would give more flexibility to the people that were already working on it</p><p>The designs has been entirely created by one of the m&s worker and it\s significally different and more modern compared to the main site. That means that all the blocks were created brand new and nothing from the main site was used</p><p>With time, a lot of the new blocks has been exported from the new site to the main site, as they wanted to have a new designs in some pages</p>',
                publish_date: '2020-04-12',
                images: ['mathys-squire_scaleup-quarter.png', 'mathys-squire_scaleup-quarter_strateby_investments.png']
            },
            {
                title: 'Elder',
                url: 'https://web.archive.org/web/20220501131927/https://www.elder.org/',
                technologies: ['wp'],
                description: '<p>Elder was previously hosted in an online CMS, so the first thing we has to do was the convert all pages from their structure to the new structure, in order to keep all the content</p><p>It took significally time but we were able to convert all with the new gutenberg custom block structure</p>',
                publish_date: '2020-04-12',
                images: ['elder.png', 'elder-live-in-care.png']
            },
            {
                title: 'Mathys & Squire',
                url: 'https://www.mathys-squire.com/',
                technologies: ['wp'],
                description: '<p>Mathys & Square was previously created in an old and very different cms, they wanted to keep the old design and have a full rebuild in WordPress</p>',
                publish_date: '2020-04-12',
                images: ['mathys-squire.png', 'mathys-people.png', 'mathys-sectors.png']
            },
            {
                title: 'AHSNNetwork',
                url: 'https://web.archive.org/web/20210414050737/https://www.ahsnnetwork.com/',
                technologies: ['wp'],
                description: '<p>AHSNNetwork started as a very slow WordPress Visual Composer website that we converted to be more flexible</p><p>Previously the main site and the Atlas site were 2 separated domains, we converted them to be a single site with the possiblity to have different design headers depending on a field inside each page</p>',
                publish_date: '2020-04-12',
                images: ['ahsnnetwork.png']
            },
            {
                title: 'Brompton',
                url: 'https://www.bromptontech.com/',
                technologies: ['wp'],
                description: '<p>Brompton has been quite the challenge, as the client requested a fully editable website with very fast loading times, so we removed Visual Composer from the list and went with creating highly customazable blocks in Gutenberg</p>',
                publish_date: '2020-04-12',
                images: ['brompton.png']
            },
            {
                title: 'Stephenson Harwood',
                url: 'https://www.offshoreenergylaw.com/',
                technologies: ['d9'],
                description: '<p>Stephenson Harwood asked us for a very cutomizable multisite where they would be able to create a new site in 0 time, and Drupal was the best option for that</p><p>Directly from the cms they were able to create a new site, set up name, logos, descriptions, and after we would connect the domain to the server, all was working withouth any problem</p>',
                publish_date: '2020-04-12',
                images: ['stephenson_harwood.png', 'stephenson_harwood_2.png', 'stephenson_harwood_3.png', 'stephenson_harwood_4.png', 'stephenson_harwood_5.png', 'stephenson_harwood_6.png']
            },
        ],
    },
    {
        id: 3,
        title: 'Freelance Web Developer',
        company: {
            name: 'Piero Nanni',
            url: 'https://www.pieronanni.com',
        },
        location: 'London, UK',
        description: '<p>In my personal free time I like creating websites for people who is in need:</p><ul><li><a href="https://www.saraannanadalini.com" target="_blank" title="Visit Sara Anna Nadalini">Sara Anna Nadalini</a> (WordPress, personal portfolio)</li><li><a href="https://www.labuonabottega.it" target="_blank" title="Visit La Buona Bottega">La Buona Bottega</a> (Drupal 8, e-commerce based on Ubercart and Bootstrap)</li><li><a href="https://www.animazionelepiccolepesti.it" target="_blank" title="Visit Animazione le Piccole Pesti">Animazione le Piccole Pesti</a> (WordPress based on 100% custom blocks for Gutenberg. This side does have a <a href="https://store.animazionelepiccolepesti.it/" target="_blank" title="Visit Animazione le Piccole Pesti Store">store</a> on a subdomain, Drupal based)</li></ul><p>I love experimenting with new ideas and creating useful tools:</p><ul><li><a href="https://www.pieronanni.com" target="_blank" title="Visit Piero Nanni">Piero Nanni</a> (Drupal 8, my personal website)</li><li><a href="https://www.cronometro.info" target="_blank" title="Cronometro.info">Cronometro.info</a> (<a href="https://github.com/morphalex90/cronometro.info" target="_blank" title="View Cronometro.info on GitHub">Github</a>)</li><li><a href="https://tools.morpheus90.com" target="_blank" title="Visit SEO Tools">SEO Tools</a> (PHP, useful checkups that I usually check on a website. Currently rebuilding in Laravel)</li></ul>',
        description_cv: '<ul><li>Built tools and websites for clients and myself in WP, Drupal, Laravel and React</li><li>Tested latest technologies and best practices on current and new projects</li><li>Optimised e-commerce sites to increase sells with better rankings</li></ul>',
        start_date: '2016-03-01',
        end_date: null,
        projects: [
            // {
            //     title: 'OnlyDogs',
            //     url: 'https://onlydogs.icu',
            //     github: 'https://github.com/morphalex90/onlydogs.icu',
            //     technologies: ['react'],
            //     description: '<p>It uses the https://thedogapi.com API</p>',
            //     publish_date: '2023-07-16',
            //     images: ['onlydogs.png']
            // },
            {
                title: 'OnlyCats',
                url: 'https://onlycats.icu',
                github: 'https://github.com/morphalex90/onlycats.icu',
                technologies: ['react'],
                description: '<p>It uses the https://thecatapi.com API</p>',
                publish_date: '2023-04-16',
                images: ['onlycats.png']
            }, {
                title: 'Piero Nanni.me',
                url: 'https://www.pieronanni.me',
                github: 'https://github.com/morphalex90/pieronanni_react',
                technologies: ['react'],
                description: '<p>My current website design was not something I have happy about, so I created a new version and, because lately I\'ve been more in touch with React, it\'s now Next.js based</p>',
                publish_date: '2022-11-01',
                images: ['pieronanni_me.png']
            },
            {
                title: 'SEO Tools',
                url: 'https://tools.morpheus90.com',
                technologies: ['laravel', 'react'],
                github: 'https://github.com/morphalex90/tools',
                description: '<p>During the develop of my websites I realized that I was missing a tool that would group the functions I use the most.</p><p>After digging the net looking for something useful and not founding something that pleased me, I\'ve started developing this website where I could insert all the tools I needed, in particular:</p><ul><li>check of title and alt on images</li><li>check of all the headings</li><li>check of all the meta datas</li><li>check of the file robots.txt and it\'s content</li><li>check of the sitemap existence and it\'s content</li></ul><p>After lots of tests and fixes, I\'ve finally released the first version built in pure HTML and Javascript / jQuery.</p><p>A first rebuild was made, by converting the project into a full Laravel installation in order to have better structure, but still I was not satisfied.</p><p>Then a second rebuild was made, this time with a combination of React in front-end (published in Netlify) and a Lumen back-end hosted into my server.<br />I\'ve choose this combination during my initial studies with React because I find that React is pretty fast and the back-end is only called by API when needed.<br />The final result is really fast compared to the previous 2 and this time I\'m quite happy with this version.</p>',
                publish_date: '2020-07-02',
                images: ['tools.png']
            },
            {
                title: 'Tati\'s Wedding',
                url: 'https://www.tatiswedding.it/',
                github: 'https://github.com/morphalex90/tatiswedding',
                technologies: ['react'],
                description: '<p>A very close friend of mine was getting married and I\'ve come with the idea to create a website that would hold all the informations about locations and what to do</p><p>Additionally, a RSVP system was in place for all the people to confirm their partecipation (it has now being removed as the even is already finished)</p>',
                publish_date: '2020-05-13',
                images: ['tatiswedding.png']
            },
            {
                title: 'Store Animazione le Piccole Pesti',
                url: 'https://web.archive.org/web/20210411065823/https://store.animazionelepiccolepesti.it/',
                technologies: ['d8'],
                description: '',
                publish_date: '2020-05-13',
                images: ['storeanimazione-home.png', 'storeanimazione-category.png', 'storeanimazione-laboratori.png', 'storeanimazione-promozioni.png']
            },
            {
                title: 'Animazione le Piccole Pesti',
                url: 'https://web.archive.org/web/20200806163843/https://www.animazionelepiccolepesti.it/',
                technologies: ['wp'],
                description: '<p>Animazione Le Piccole Pesti is the commerce activity for children entertainment during birthdays, weddings, etc... created by a good friend of mine.</p><p>The site has been rebuild in order to have a better look compared to the old design, and lots of pages has been deleted and/or regrouped, in order to make it simpler from users and to gather informations.</p><p>It\'s based on Gutenberg blocks in order to provide a better back-end experience.</p><p>A Drupal based <a href="https://store.animazionelepiccolepesti.it/" target="_blank" title="Visit Animazione Le Piccole Pesti e-commerce">e-commerce</a> has been built in order to sell online the merchandising sold on the shop</p>',
                publish_date: '2020-04-12',
                images: ['animazione.png']
            },
            {
                title: 'Cronometro.info',
                url: 'https://www.cronometro.info/',
                github: 'https://github.com/morphalex90/cronometro.info',
                technologies: ['html5'],
                description: '<p>Project born with the purpose of showing my js/jQuery knowledge and of testing how Google AdWords works (still to implement)</p><p>The result is a simple stopwatch that can handle partial timings.</p><p>It has been rebuilt in 2020 by using only vanilla js and drop the dependency on jQuery</p>',
                publish_date: '2018-03-19',
                images: ['cronometro.png']
            },
            {
                title: 'Piero Nanni.com',
                url: 'https://www.pieronanni.com',
                github: 'https://github.com/morphalex90/pieronanni_drupal',
                technologies: ['d9'],
                description: '<p>This website starts as a project at the beginning of 2017 when I wanted to pass from my old domain morpheus90.com to something much more professional, so I bought pieronanni.it and pieronanni.com domains, then installed Drupal 8 and finally started to add all my works.</p><p>The first version came out in march 2018 and it was created by using a custom child theme of Bootstrap, it was ok at that time even if having such a dependency was not the best.</p><p>Time passes and I finally learn how to fully create a theme from& scratch, then I\'ve rebuild this site in order to give a better look and be way more optimized. I am really proud of the result!</p>',
                publish_date: '2018-03-02',
                images: ['pieronanni-homepage.png', 'pieronanni-about.png', 'pieronanni-projects.png', 'pieronanni-contact.png']
            },
            {
                title: 'La Buona Bottega',
                url: 'https://www.labuonabottega.it',
                technologies: ['d8'],
                description: '<p>Ecommerce of product eco friendly created with Drupal 8 and the Ubercart module</p><p>It has been created as much content types as much product types we have, so it\'s possible to completly customize both fields and template/block, in addition to have the total control from backoffice for the meta managment for every single product</p><p>The theme is based on Bootstrap and it has been created a child theme in order to override it</p><p>Lots of private pages has been created in order to add tools for the editor user in order to manage the content creation and the handling of products/users/orders</p>',
                publish_date: '2017-09-01',
                images: ['labuonabottega.png']
            },
            {
                title: 'Sara Anna Nadalini',
                url: 'https://www.saraannanadalini.com',
                technologies: ['react'],
                description: '<p>This is a static website based on WordPress used as a project and works collection for the content creator Sara Anna Nadalini</p><p>The theme is based on one of the basic WordPress theme, completly revisited in order to make it 100% customized with the owner wishes</p><p>This is one of the fastest WordPress website I\'ve ever build, thanks to the fact that there are very few contents and lots of external links</p>',
                publish_date: '2016-03-20',
                images: ['sara-anna-nadalini.png']
            },
        ],
    },
    {
        id: 2,
        title: 'Web Developer',
        company: {
            name: 'Magic',
            url: 'https://www.magicnet.it',
        },
        location: 'Bologna, Italy',
        description: '<p>Web Developer @ Magic (Bologna, Italy), with the task of developing websites and e-commerce platforms with WordPress, Drupal and Magento.</p><p>Over three years (for two of them I was the only developer) I learnt about how to build websites from graphical ideas, publishing them with WHM and cPanel, keeping them updated and optimizing them with SEO (thanks to <a href="https://visual-seo.com/" target="_blank" title="Visit Visual SEO Studio">Visual SEO Studio</a> and <a href="https://www.screamingfrog.co.uk" target="_blank" title="Visit Screaming Frog">Screaming Frog</a>) and lots of useful tweaks.</p><p>Drupal 8:</p><ul><li><a href="https://www.oleodinamicabolognese.it" target="_blank" title="Oleodinamica Bolognese">Oleodinamica Bolognese</a> (Bootstrap based theme with private catalogue)</li><li><a href="http://www.eurogruamici.com" target="_blank" title="EuroGru Amici">EuroGru Amici</a> (Bootstrap based theme based on a previous bought theme not well structured)</li><li><a href="https://www.iporticihotel.com/en" target="_blank" title="I Portici Hotel Bologna">I Portici Hotel Bologna</a> (Bootstrap based theme; My best Drupal 8 work in terms of customization)</li></ul><p>Drupal 7:</p><ul><li><a href="https://www.magicnet.it" target="_blank" title="Magic">Magic</a> (the web agency website; I made it faster and lighter than it was before)</li><li><a href="https://www.okbedandbreakfast.it" target="_blank" title="OkBedAndBreakfast">OkBedAndBreakfast</a> (three-year internal project; My best Drupal 7 work in terms of customization)</li><li><a href="http://www.montieco.it" target="_blank" title="Montieco">Montieco</a> (Bootstrap based theme with a Drupal based URM)</li><li><a href="http://www.edilforme.it" target="_blank" title="Edilforme">Edilforme</a> (Bootstrap based theme with advanced back-office functions)</li><li><a href="https://www.arredart.com/" target="_blank" title="Arredart">Arredart</a> (ajax calls with optimized queries in order to load the stands)</li><li><a href="http://www.bedandbreakfast.bo.it/en" target="_blank" title="Bed&amp;Breakfast Farinelli">Bed&amp;Breakfast Farinelli</a> (converted to a responsive theme)</li></ul><p>WordPress:</p><ul><li><a href="https://web.archive.org/web/20190129221656/http://www.mira-srl.com/" target="_blank" title="Mira SRL">Mira SRL</a> (first WordPress project in this web agency, mainly based on image galleries)</li><li><a href="https://medicina-estetica-bologna.it/" target="_blank" title="Dott. Piero Notarrigo">Dott. Piero Notarrigo</a> (converted to a responsive theme)</li><li><a href="https://www.centrocarrelli.net" target="_blank" title="Centro Carrelli">Centro Carrelli</a> (custom product\'s page with slider and custom fields)</li></ul><p>Magento:</p><ul><li><a href="https://web.archive.org/web/20230325233550/https://www.espositori-pubblicitari.it/" target="_blank" title="Espositori Pubblicitari">Espositori Pubblicitari</a> (converted to a responsive theme and added structured data for products and news)</li><li><a href="https://www.plexiarredo.it" target="_blank" title="Plexi Arredo">Plexi Arredo</a> (integrated Google Shopping and added structured data for products)</li></ul>',
        description_cv: '<ul><li>In charge of all the production for 2 out of 3 years</li><li>Developed and maintained WP and Drupal sites</li><li>SEO optimized already created sites in WP, Drupal and Magento and achieved better ranks in Google search</li></ul>',
        start_date: '2015-05-01',
        end_date: '2018-06-15',
        projects: [
            {
                title: 'EuroGru Amici',
                url: 'https://www.eurogruamici.com/',
                technologies: ['d8'],
                description: '<p>One of the simplest and lightest Drupal 8 website built, most part of the content are high quality photos and they are displayed by using Views.</p><p>The website is based on the Bootstrap theme and it\'s been optimized for search engines so it\'s light and easy to navigate, both from desktop and mobile</p>',
                publish_date: '2020-04-12',
                images: ['eurogru-amici.png']
            },
            {
                title: 'Bed & Breakfast Farinelli',
                url: 'https://web.archive.org/web/20160920210322/http://www.bedandbreakfast.bo.it/',
                technologies: ['d7'],
                description: '<p>Created many years ago not by me, this website was not build in modern technologies and I got the chance to convert the current theme into a responsive one, in order to be adeguate for tablet and mobile.</p><p>Unfortunately it has been closed in 2020. You can see the old live version on the link below</p>',
                publish_date: '2020-04-12',
                images: ['farinelli.png']
            },
            {
                title: 'Oleodinamica Bolognese',
                url: 'https://web.archive.org/web/20220127143936/https://www.oleodinamicabolognese.it/',
                technologies: ['d8'],
                description: '<p>Website based on Drupal 8 and Bootstrap, previously was built with Drupal 6.</p><p>The graphic layout has been completly redisigned and, as for the previous version, the catalog is visible only for register users. Users don\'t have to choose the password during the registration but it will be sent directly in email, so the registration process is much more faster.</p><p>The newsletter block is connected with the MailUp service, a complete email and SMS delivery solution.</p>',
                publish_date: '2020-04-12',
                images: ['oleodinamicabolognese.png']
            },
            {
                title: 'Montieco',
                url: 'http://www.montieco.it/',
                technologies: ['d7'],
                description: '<p>Montieco is a company that operates in the management and disposal of waste, the website has been renewed from an old Drupal 6 to a new Drupal 7.</p><p>New functionalities includes:</p><ul><li>being linked with Win Sm@.R.T.® EVO for the economic and organizational administrative management of waste with registered customers</li><li>integration with an URM (CRM) being able to have the complete history of all customers transactions, including the answers from mail</li></ul>',
                publish_date: '2020-04-12',
                images: ['montieco.png']
            },
            {
                title: 'Edilforme',
                url: 'https://www.edilforme.it/',
                technologies: ['d7'],
                description: '<p>This is the only Drupal 7 site based on a Bootstrap theme I\'ve created, it\'s built with well structured back-end in order to allows the client to have a better data entry experience.</p><p>Advanced functionality includes a night cron that loads all the proprieties, generates an xml based on that content, validates the xml with a xsd and send the data by ftp to immobilare.it (the #1 estate ads portal in Italy)</p>',
                publish_date: '2020-04-12',
                images: ['edilforme.png']
            },
            {
                title: 'Arredart',
                url: 'https://www.arredart.com/',
                technologies: ['d7'],
                description: '<p>Showcase website used to exhibit all the stands build by the company.</p><p>Inside the stand page, each time a user would click on an exhibition or a category, the relative stands were displayed with the use of ajax and custom queries, in addition to a small animation</p>',
                publish_date: '2020-04-12',
                images: ['arredart.png']
            },
            {
                title: 'I Portici Hotel',
                url: 'https://web.archive.org/web/20190126045123/https://www.iporticihotel.com/en',
                technologies: ['d8'],
                description: '<p>This websites previously was a Drupal 7 with 4 languages and now, after the new version and the complete restyling, it\'s a Drupal 8 with 2 languages (this is the first Drupal 8 published in Magic).</p><p>Back-end functionalities includes a xml Bologna\'s events reader with a list displayed on a page, and for each event the administrator could save the it and the content of the event page with the possibility to moderate it before publishing.</p><p>Unfortunately the site has been rebuild in 2019 and the current live site is not my work anymore. You can see the previous version on the link below</p>',
                publish_date: '2020-04-12',
                images: ['iportici.png']
            },
            {
                title: 'Mira',
                url: 'https://web.archive.org/web/20190129221656/http://www.mira-srl.com/',
                technologies: ['wp'],
                description: '<p>This is the first WordPress website that I\'ve 100% developed since I\'ve started working at Magic, it\'s based on a customised version of the "Twenty Thirteen" theme as it was the most similar theme based on the graphic proposal.</p><p>The contact page is based on the CF7 plugin and the newsletter is connected to the MailUp service</p>',
                publish_date: '2020-04-12',
                images: ['mira.png']
            },
            {
                title: 'OkBedAndBreakfast',
                url: 'https://web.archive.org/web/20220331015500/https://www.okbedandbreakfast.it/',
                technologies: ['d7'],
                description: '<p>First project in Drupal 7 that was given to me, shortly after I arrived at Magic. At the beginning the theme was completely different and after buying a new theme and re importing all users and structures already present I\'ve started developing all the missing parts.</p><p>Once the new site was ready, we bought bed & breakfast data and locations from the Chamber of Commerce for all the Italian regions and then we imported them in order to have much more bed & breakfast to show in the website.</p><p>This site was my training wheel for Drupal 7, a lot of the sections and procedures of the site have been rewritten during my years at Magic because I\'ve learned how to manage Drupal code in a more optimized way, so that in the end it could be a better and complete website.</p><p>At the moment the site is completely synchronized with MailUp with all the data form the structures, so we can send newsletters directly to the users we want and according to the desired purposes, such as sending emails automatically every few days to the owners that have not yet inserted the images of the structure.</p>',
                publish_date: '2020-04-12',
                images: ['okbedandbreakfast.png']
            },
            {
                title: 'Dott. Piero Notarrigo',
                url: 'https://medicina-estetica-bologna.it/',
                technologies: ['wp'],
                description: '<p>Created many years ago not by me, this website was not build in modern technologies and I got the chance to convert the current theme into a responsive one, in order to be adeguate for tablet and mobile.</p><p>It was my first full responsive conversion project and the results were pretty amazing</p>',
                publish_date: '2020-04-12',
                images: ['medicina-estetica.png']
            },
            {
                title: 'Centro Carrelli',
                url: 'https://web.archive.org/web/20190217091807/https://www.centrocarrelli.net/',
                technologies: ['wp'],
                description: '<p>The Centro Carelli website was based on the beautiful "Automotive" WordPress theme, with the inclusion of an advanced search system and the field mapping on the specific product pages</p><p>Unfortunately it has been rebuild in 2019, so the current live site is not my work anymore. You can see the previous version on the link below</p>',
                publish_date: '2020-04-12',
                images: ['centrocarrelli.png']
            },
            {
                title: 'Espositori Pubblicitari',
                url: 'https://web.archive.org/web/20230325233550/https://www.espositori-pubblicitari.it/',
                technologies: ['magento'],
                description: '<p>This is one of the ecommerce handled internally and based on magento, the project has started more than 10 years ago so when we understand that the most of the traffic comes from mobile, the theme as been converted in order to make it optimized for smartphone and tablet.</p><p>In addition to make it responsive, we made it as light as we could because it loaded 7 fonts and bigger images than what we needed.</p><p>Thanks to all this fixes, the website weight drop by 30% and it has speed up a little. Better improvement would be achieved by updating some of the plugins but we could not because they will not be compatible with the current CMS version</p>',
                publish_date: '2020-04-12',
                images: ['espositori.png']
            },
        ],
    },
    {
        id: 1,
        title: '3D modeler and Web Programmer',
        company: {
            name: 'BackRaven',
            url: 'https://www.blackravenproduction.com',
        },
        location: 'Bologna, Italy',
        description: '<p>BlackRaven was a small indie software house formed by a group of close friends with the same passion about videogames. We developed and published some apps for iOS devices as well as a few pc games.</p><p>My first role was web programmer, so I created and maintained the main <a href="https://www.blackravenproduction.com/" target="_blank" title="Visit BlackRaven">website</a> in WordPress. Other than the site, I was in charge of creating databases connections for the apps we developed.<br />To cover for one of the vacancies in our team, I also learnt basic 3D modelling using programs like <a href="http://www.milkshape3d.com/" target="_blank" title="visit Milkshape">Milkshape</a> and <a href="https://www.autodesk.co.uk/products/3ds-max/overview" target="_blank" title="3ds Max">3ds Max</a> (my creations examples <a href="https://www.youtube.com/watch?v=nvR8JaftYb8" target="_blank" title="See the models">video</a>).</p>',
        description_cv: '<ul><li>Learnt basic 3D modelling using Milkshape and 3ds Max (<a href="https://www.youtube.com/watch?v=nvR8JaftYb8" target="_blank" title="See the models">video</a> examples)</li><li>Created and maintained the main <a href="https://www.blackravenproduction.com/" target="_blank" title="Visit BlackRaven">website</a> in WP</li><li>In charge of creating databases connections for the developed apps</li></ul>',
        start_date: '2011-02-01',
        end_date: '2015-08-01',
        projects: [
            {
                title: 'BlackRaven',
                url: 'https://www.blackravenproduction.com/',
                technologies: ['wp'],
                description: '<p>I\'ve been part of this indie team since 2011 until the closing in 2015, my role was web designer and 3D modeller.</p><p>In this website (and in the <a href="https://www.facebook.com/Black-Raven-274328735978223/" target="_blank" title="Check out the Facebook page"> Facebook page</a>) we have included all the products that we developed during this years, all the news of the exibitions we participed and all the events we went</p>',
                publish_date: '2020-04-12',
                images: ['blackraven.png']
            },
        ],
    },
];