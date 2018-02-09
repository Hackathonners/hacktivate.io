<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Display landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('pages.welcome');
    }

    /**
     * Display a listing of mentors.
     *
     * @return \Illuminate\Http\Response
     */
    public function mentors()
    {
        $mentors = [
            [
                'name' => 'Rui Ribeiro',
                'position' => 'SysAdmin',
                'company' => 'HASLab, INESC TEC',
                'image' => 'rribeiro',
                'description' => 'Rui Miguel is a freelance software developer and self taught sysadmin who prefers backend development because forms are boring.
    Currently collaborating with HaSLab in a weird mix of researcher/sysadmin in the quest of creating tools and infrastructure to optimize everyday tasks via automation and integration.
    He no longer uses free time to keep working, instead, enjoys the outdoors and tries to wake up the long lost creative side.',
            ],
            [
                'name' => 'Hugo Matalonga',
                'position' => 'Freelancer Full-stack Developer',
                'company' => '',
                'image' => 'hmatalonga',
                'description' => 'Hugo Matalonga is a freelancer Full-Stack Developer working for over 6+ years. Most of his late work concerns developing scalable progressive web applications.
    From very young age, he discovered the passion for programming and kept doing it ever since.
    He has a Bachelor’s degree in Computer Engineering at the University of Beira Interior.
    He is a huge enthusiastic of all things open-source and always eager to learn more news topics and technologies as much as he can.
    Besides his freelance work, he also has been part of a research project in Green Computing for the last year. Recently he has started getting into Machine Learning.',
            ],
            [
                'name' => 'Nuno Machado',
                'position' => 'Senior Researcher',
                'company' => 'HASLab',
                'image' => 'nmachado',
                'description' => 'Nuno Machado is a senior researcher at HASLab (INESC TEC & University of Minho), working to make large-scale distributed systems more efficient and reliable. He is a firm believer that software development can be both challenging and fun. The former encouraged him to do a Ph.D. in Computer Science at Instituto Superior Técnico and an internship at Microsoft Research in Redmond, during which he developed automated tools to debug concurrency bugs. The latter inspired him to participate in several programming contests, such as Microsoft Imagine Cup (won the 1st prize in 2010) and Sapo Codebits.',
            ],
            [
                'name' => 'Mike Elsmore',
                'position' => 'Developer & Community Organiser',
                'company' => '',
                'image' => 'melsmore',
                'description' => 'Mike loves building, tinkering and making odd things happen with code. Using my time to share knowledge on rapid development and different databases. Most of the time he can be found in the middle of a prototype in some combination of JavaScript, server tech and odd API\'s. Mike also happens to be an active part of the hacker subculture, taking part in hackathons and development conferences. As well as running his own.',
            ],
        ];

        return view('pages.mentors', compact('mentors'));
    }

    /**
     * Display a listing of jurors.
     *
     * @return \Illuminate\Http\Response
     */
    public function jurors()
    {
        $jurors = [
            [
                'name' => 'André Santos',
                'position' => 'PhD Student & Researcher',
                'company' => 'HASLab, INESC TEC',
                'image' => 'andrefs',
                'description' => 'André Santos studied Informatics Engineering at University of Minho. He was a member of CeSIUM, worked as a sys admin at Subvisual.co, and as web developer at SAPO.pt and at Contentful.com. Currently, he\'s getting a PhD in Informatics at FCUP and working as a researcher at INESC-TEC. He\'s also the creator of http://botoes.co/ and a frequent participant in hackathons such as SAPO Codebits and Pixels Camp. His main interests are natural language processing, semantic web and web development.',
            ],
            [
                'name' => 'Orlando Belo',
                'position' => 'Associate Professor',
                'company' => 'University of Minho',
                'image' => 'obelo',
                'description' => 'Orlando Belo is an Associate Professor, with Habilitation, in the Department of Informatics at University of Minho, Portugal. He is also a member of the ALGORITMI R&D Centre, at the same university, working in Business Intelligence, with particular emphasis in areas such as Databases, Data Warehousing Systems, OLAP, Data Visualization, and Data Mining. During the last few years he was involved with several projects in the decision support systems area designing and implementing computational platforms for specific applications, such as fraud detection and control in telecommunication systems, data quality evaluation, and ETL systems for industrial data warehousing systems.',
            ],
            [
                'name' => 'Pedro Carneiro',
                'position' => 'Co-Founder & CTO',
                'company' => 'Nutrium',
                'image' => 'pcarneiro',
                'description' => 'Pedro Carneiro studied Informatics Engineering at the University of Minho.
When he was studying at the university, he was highly involved in CeSIUM, the students association of Informatics Engineering course.
There he had the opportunity to be the director of CAOS, a department of CeSIUM that develops open source software and organizes talks and workshops about new technologies.
After University, he co-founded Nutrium with his friends, a nutrition software aiming to improve the relationship between dietitians and patients, where he is currently CTO.
He likes to read and learn about technology as well as playing soccer.',
            ],
        ];

        return view('pages.jurors', compact('jurors'));
    }
}
