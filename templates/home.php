<?php
$heroimage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvARcp_7T2jbszuz8AFGf7k9cQMY4atBoEKg&s';
$registerurl = new moodle_url('/local/scholarship/apply.php');
$learnmoreurl = new moodle_url('/login/index.php');

$stats = [
    ['count' => '+300', 'description' => get_string('home:stat1_desc', 'local_scholarship')],
    ['count' => '+900', 'description' => get_string('home:stat2_desc', 'local_scholarship')],
    ['count' => '+50', 'description' => get_string('home:stat3_desc', 'local_scholarship')],
];

$whatisitcards = [
    ['title' => get_string('home:what1_title', 'local_scholarship'), 'description' => get_string('home:what1_desc', 'local_scholarship'), 'image' => new moodle_url('/local/scholarship/assets/img/financial_support_picture.png'), 'alt' => 'Financial support picture'],
    ['title' => get_string('home:what2_title', 'local_scholarship'), 'description' => get_string('home:what2_desc', 'local_scholarship'), 'image' => new moodle_url('/local/scholarship/assets/img/coaching_picture.png'), 'alt' => 'Coaching and mentoring picture'],
    ['title' => get_string('home:what3_title', 'local_scholarship'), 'description' => get_string('home:what3_desc', 'local_scholarship'), 'image' => new moodle_url('/local/scholarship/assets/img/training_experience.png'), 'alt' => 'Training and professional experience picture'],
    ['title' => get_string('home:what4_title', 'local_scholarship'), 'description' => get_string('home:what4_desc', 'local_scholarship'), 'image' => new moodle_url('/local/scholarship/assets/img/community_picture.jpeg'), 'alt' => 'Picture of the community'],
];

$conditions = [
    get_string('home:condition1', 'local_scholarship'),
    get_string('home:condition2', 'local_scholarship'),
    get_string('home:condition3', 'local_scholarship'),
    get_string('home:condition4', 'local_scholarship'),
    get_string('home:condition5', 'local_scholarship'),
    get_string('home:condition6', 'local_scholarship'),
];

$processsteps = [
    ['number' => '01', 'title' => get_string('home:process1_title', 'local_scholarship'), 'description' => get_string('home:process1_desc', 'local_scholarship')],
    ['number' => '02', 'title' => get_string('home:process2_title', 'local_scholarship'), 'description' => get_string('home:process2_desc', 'local_scholarship')],
    ['number' => '03', 'title' => get_string('home:process3_title', 'local_scholarship'), 'description' => get_string('home:process3_desc', 'local_scholarship')],
    ['number' => '04', 'title' => get_string('home:process4_title', 'local_scholarship'), 'description' => get_string('home:process4_desc', 'local_scholarship')],
    ['number' => '05', 'title' => get_string('home:process5_title', 'local_scholarship'), 'description' => get_string('home:process5_desc', 'local_scholarship')],
];

$testimonials = [
    ['name' => 'Andrea Muhima.', 'role' => get_string('home:testimonial1_role', 'local_scholarship'), 'text' => get_string('home:testimonial3_text', 'local_scholarship'), 'image' => new moodle_url('/local/scholarship/assets/img/scholar_andy.jpeg')],
    ['name' => 'Vincent Tshipamba', 'role' => get_string('home:testimonial2_role', 'local_scholarship'), 'text' => get_string('home:testimonial1_text', 'local_scholarship'), 'image' => new moodle_url('/local/scholarship/assets/img/scholar_vincent.jpg')],
    ['name' => 'Joediv Ilunga.', 'role' => get_string('home:testimonial3_role', 'local_scholarship'), 'text' => get_string('home:testimonial2_text', 'local_scholarship')],
];

$partners = [
    'Leadership Academia University',
    'Université de Kinshasa',
    'Université Protestante du Congo',
    'ISIPA',
    'Université Catholique du Congo',
    'INBTP',
    'Université Loyola du Congo',
    'HEC Kinshasa',
];

$faqitems = [
    ['question' => get_string('home:faq1_q', 'local_scholarship'), 'answer' => get_string('home:faq1_a', 'local_scholarship')],
    ['question' => get_string('home:faq2_q', 'local_scholarship'), 'answer' => get_string('home:faq2_a', 'local_scholarship')],
    ['question' => get_string('home:faq3_q', 'local_scholarship'), 'answer' => get_string('home:faq3_a', 'local_scholarship')],
    ['question' => get_string('home:faq4_q', 'local_scholarship'), 'answer' => get_string('home:faq4_a', 'local_scholarship')],
    ['question' => get_string('home:faq5_q', 'local_scholarship'), 'answer' => get_string('home:faq5_a', 'local_scholarship')],
    ['question' => get_string('home:faq6_q', 'local_scholarship'), 'answer' => get_string('home:faq6_a', 'local_scholarship')],
    ['question' => get_string('home:faq7_q', 'local_scholarship'), 'answer' => get_string('home:faq7_a', 'local_scholarship')],
    ['question' => get_string('home:faq8_q', 'local_scholarship'), 'answer' => get_string('home:faq8_a', 'local_scholarship')],
];
?>
<div class="scholarship-home scholarship-home-bg">
    <section class="relative isolate flex min-h-screen items-center overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo s($heroimage); ?>');">
        </div>
        <div
            class="absolute inset-0 bg-gradient-to-b from-slate-950/45 via-slate-950/75 to-slate-950/90 backdrop-blur-sm">
        </div>
        <div
            class="relative z-10 flex w-full flex-col items-center justify-center bg-gradient-to-b from-transparent via-black/50 to-black/80 px-6 py-60 text-center sm:py-60 md:py-60">
            <h1 class="mb-4 font-extrabold text-white text-3xl md:text-4xl leading-tight tracking-wide">
                <?php echo get_string('home:title', 'local_scholarship'); ?>
            </h1>
            <p class="mx-auto mb-8 max-w-2xl text-gray-200 text-lg md:text-xl">
                <?php echo get_string('home:description', 'local_scholarship'); ?>
            </p>
            <p class="mx-auto mb-8 max-w-2xl text-gray-200 text-lg md:text-xl">
                <?php echo get_string('home:subdescription', 'local_scholarship'); ?>
            </p>
            <div class="flex md:flex-row flex-col gap-4">
                <a class="px-5 py-3 md:px-8 md:py-4 text-base md:text-lg transform animate-bounce rounded-full bg-gradient-to-r from-red-700 to-red-500 font-semibold text-white no-underline shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:text-white hover:no-underline focus:text-white focus:no-underline active:text-white active:no-underline"
                    href="<?php echo $registerurl; ?>"><?php echo get_string('home:cta_apply', 'local_scholarship'); ?></a>
                <a class="px-5 py-3 md:px-8 md:py-4 text-base md:text-lg rounded-full border-2 border-white font-semibold text-white no-underline transition duration-300 ease-in-out hover:bg-white hover:!text-slate-900 hover:no-underline focus:!text-slate-900 focus:no-underline active:!text-slate-900 active:no-underline"
                    href="<?php echo $learnmoreurl; ?>"><?php echo get_string('home:learn_more', 'local_scholarship'); ?></a>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Section Stats -->
    <section class="py-20">
        <div class="scholarship-shell text-center">
            <h2 class="text-2xl text-slate-900 md:text-4xl font-bold tracking-tight">
                <?php echo get_string('home:stats_title', 'local_scholarship'); ?>
            </h2>
            <p class="mx-auto mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                <?php echo get_string('home:stats_description', 'local_scholarship'); ?>
            </p>
            <div class="mt-14 grid gap-3 lg:grid-cols-3">
                <?php foreach ($stats as $stat): ?>
                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-8 text-center shadow-[0_24px_60px_rgba(15,23,42,0.10)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(15,23,42,0.14)]">
                        <strong
                            class="block text-2xl md:text-4xl font-black tracking-tight text-slate-900"><?php echo s($stat['count']); ?></strong>
                        <span
                            class="mt-3 block text-sm md:text-base leading-7 text-slate-600"><?php echo s($stat['description']); ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- End Section Stats -->

    <div class="scholarship-wave-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Section what is the scholarship -->
    <section class="bg-white/70 py-20 backdrop-blur-sm" id="what-is-it">
        <div class="scholarship-shell">
            <div class="text-center">
                <h2 class="text-2xl text-slate-900 md:text-4xl font-bold tracking-tight">
                    <?php echo get_string('home:what_title', 'local_scholarship'); ?>
                </h2>
                <p class="mx-auto mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:what_description', 'local_scholarship'); ?>
                </p>
            </div>
            <div class="mt-14 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <?php foreach ($whatisitcards as $card): ?>
                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white/80 shadow-[0_24px_60px_rgba(15,23,42,0.10)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(15,23,42,0.14)]">
                        <img class="rounded-t-3xl h-fit w-full" src="<?= $card['image'] ?>" alt="Home in Countryside" />
                        <div class="p-4">
                            <h3 class="text-md md:text-xl font-bold text-slate-900"><?php echo s($card['title']); ?></h3>
                            <p class="mt-2 text-sm md:text-base leading-7 text-slate-600">
                                <?php echo s($card['description']); ?>
                            </p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- End Section what is the scholarship -->

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Steps Section -->
    <section class="">
        <div class="scholarship-surface px-4 py-6">
            <div class="text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">
                    <?php echo get_string('home:process_title', 'local_scholarship'); ?>
                </h2>
                <p class="mx-auto mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:process_description', 'local_scholarship'); ?>
                </p>
            </div>
            <div class="mt-12 grid gap-[14px] xl:grid-cols-5 md:grid-cols-2">
                <?php foreach ($processsteps as $step): ?>
                    <article
                        class="rounded-[1.75rem] border border-slate-200/80 bg-white p-3 text-center shadow-[0_20px_50px_rgba(15,23,42,0.1)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">
                        <div
                            class="animate-bounce mx-auto mb-3 md:mb-5 inline-flex h-16 w-16 items-center justify-center rounded-full border border-red-200 text-lg md:text-xl font-black tracking-[0.18em] text-red-600">
                            <?php echo s($step['number']); ?>
                        </div>
                        <h3 class="text-lg md:text-xl font-bold text-slate-900">
                            <?php echo s($step['title']); ?>
                        </h3>
                        <p class="mt-3 text-sm md:text-base leading-7 text-slate-600">
                            <?php echo s($step['description']); ?>
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- End Steps Section -->

    <div class="scholarship-wave-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Conditions Section -->
    <section class="py-20">
        <div class="scholarship-shell">
            <div class="scholarship-surface p-8 md:p-10">
                <div>
                    <span
                        class="inline-flex rounded-full border border-red-200 bg-red-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-red-600"><?php echo get_string('home:conditions_badge', 'local_scholarship'); ?></span>
                    <h2 class="mt-5 text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">
                        <?php echo get_string('home:conditions_title', 'local_scholarship'); ?>
                    </h2>
                    <p class="mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:conditions_description', 'local_scholarship'); ?>
                    </p>
                </div>
                <div class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <?php foreach ($conditions as $condition): ?>
                        <article
                            class="flex gap-4 rounded-[1.5rem] border border-slate-200/80 bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">
                            <span
                                class="animate-pulse inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 font-bold text-red-600">✓</span>
                            <p class="text-sm md:text-base leading-7 text-slate-700"><?php echo s($condition); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- End Conditions Section -->

    <div class="scholarship-wave-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Process Section -->
    <section class="bg-white/70 py-20 backdrop-blur-sm">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">
                <?php echo get_string('home:how_to_apply_title', 'local_scholarship'); ?>
            </h2>
            <p class="mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                <?php echo get_string('home:how_to_apply_description', 'local_scholarship'); ?>
            </p>
        </div>
        <img src="<?= new moodle_url('/local/scholarship/assets/img/user_journey.png') ?>"
            alt="Parcours utilisateur de souscription à la bourse Vodacom" class="h-full w-full">
    </section>
    <!-- End Process Section -->

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- CTA Section -->
    <section class="py-20">
        <div class="scholarship-shell">
            <div
                class="scholarship-surface grid items-center gap-8 p-8 md:p-10 lg:grid-cols-[minmax(0,1fr)_minmax(320px,0.9fr)]">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-5xl">
                        <?php echo get_string('home:cta_title', 'local_scholarship'); ?>
                    </h2>
                    <p class="mt-5 max-w-2xl text-md md:text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:cta_description', 'local_scholarship'); ?>
                    </p>
                    <div class="mt-8 ">
                        <span class="relative inline-block">
                            <span class="absolute -inset-1 animate-ping rounded-full bg-red-400 opacity-85">
                            </span>

                            <a href="<?php echo $registerurl; ?>"
                                class="relative inline-flex h-16 items-center rounded-full scholarship-btn scholarship-btn--primary animate-bounce">
                                <?php echo get_string('home:cta_button', 'local_scholarship'); ?>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/cta-picture-square.png') ?>"
                        alt="Call to action picture" class="w-full h-full rounded-xl">
                </div>
            </div>
        </div>
    </section>
    <!-- End CTA Section -->

    <div class="scholarship-wave-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Testimonials Section -->
    <section class="bg-white/70 py-20 backdrop-blur-sm" id="testimonials-section">
        <div class="scholarship-shell">
            <div class="text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">
                    <?php echo get_string('home:testimonials_title', 'local_scholarship'); ?>
                </h2>
                <p class="mx-auto mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:testimonials_description', 'local_scholarship'); ?>
                </p>
            </div>
            <div class="mt-12 grid gap-3 md:gap-5 lg:grid-cols-3">
                <?php foreach ($testimonials as $testimonial): ?>
                    <article
                        class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 text-center shadow-[0_20px_50px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">
                        <div
                            class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-red-600 to-rose-400 text-md md:text-lg font-black text-white">
                            <?php if ($testimonial['image']): ?>
                                <img src="<?= $testimonial['image'] ?>" alt="Picture of scholar Vincent"
                                    class="w-16 h-16 rounded-full">
                            <?php else:
                                echo s(core_text::substr($testimonial['name'], 0, 1)); ?>
                            <?php endif; ?>
                        </div>
                        <h3 class="mt-5 text-lg md:text-xl font-bold text-slate-900"><?php echo s($testimonial['name']); ?>
                        </h3>
                        <span
                            class="mt-2 block text-sm font-medium text-slate-500"><?php echo s($testimonial['role']); ?></span>
                        <p class="mt-4 text-sm md:text-base leading-7 text-slate-600"><?php echo s($testimonial['text']); ?>
                        </p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- End Testimonials Section -->

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Partners Section -->
    <section class=" py-20">
        <div class="scholarship-shell text-center">
            <h2 class="text-2xl font-bold tracking-tight md:text-4xl">
                <?php echo get_string('home:partners_title', 'local_scholarship'); ?>
            </h2>
            <div class="max-w-7xl mx-auto flex flex-wrap justify-around gap-8 py-12 px-4">
                <!-- Kinshasa -->
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://ascitech.cd/" target="_blank" title="Académie des Sciences et Technologies">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-ascitech.png') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Académie des Sciences et Technologies"
                        title="Académie des Sciences et Technologies">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.launiversity.cd/" target="_blank" title="Leadership Academia University">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-lau.png') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Leadership Academia University"
                        title="Leadership Academia University">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://uwbcongo.org/" target="_blank" title="Université William Booth">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-uwb.png') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Université William Booth"
                        title="Université William Booth">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://belcampusrdc.net/" target="_blank" title="Université Technologique Bel Campus">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-UTBC_Kinshasa.png') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Université Technologique Bel Campus"
                        title="Université Technologique Bel Campus">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://unisic.ac.cd/" target="_blank" title="Université des Sciences de l'Information et de la Communication">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unisic.webp') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Université des Sciences de l'Information et de la Communication"
                        title="Université des Sciences de l'Information et de la Communication">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://upn.ac.cd/" target="_blank" title="Université Pédagogique Nationale">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-upn.png') ?>"
                        class="sm:w-20 w-16 h-auto" alt="Logo de Université Pédagogique Nationale"
                        title="Université Pédagogique Nationale">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="http://www.ista-kin.org/" target="_blank" title="Institut Supérieur des Techniques Appliquées">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-ista.png') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Institut Supérieur des Techniques Appliquées"
                        title="Institut Supérieur des Techniques Appliquées">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://isau.optsolution.net/" target="_blank" title="Institut Supérieur d'Architecture et d'Urbanisme">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-isau.png') ?>"
                        class="sm:w-24 w-16 h-auto" alt="Logo de Institut Supérieur d'Architecture et d'Urbanisme"
                        title="Institut Supérieur d'Architecture et d'Urbanisme">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.unikin.ac.cd/" target="_blank" title="Université de Kinshasa">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unikin.png') ?>"
                        alt="Logo de Université de Kinshasa" title="Université de Kinshasa"
                        class="h-auto sm:w-[4.2rem] w-12">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.upc.ac.cd" target="_blank" title="Université Protestante du Congo">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-upc.png') ?>"
                        alt="Logo de l'Université Protestante du Congo" title="Université Protestante du Congo"
                        class="h-auto sm:w-32 w-24">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.isipa.cd" target="_blank"
                    title="Institut Supérieur d'Informatique Programmation et Analyse">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-isipa.png') ?>"
                        alt="Logo de l'ISIPA" title="ISIPA" class="h-auto sm:w-18 w-12">

                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.ucc.ovh/" target="_blank" title="Université Catholique du Congo">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-ucc.png') ?>" alt="Logo de l'UCC"
                        title="Université Catholique du Congo" class="h-auto sm:w-20 w-14">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.inbtp.ac.cd" target="_blank"
                    title="Institut National du Bâtiment et des Travaux Publics">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-inbtp.png') ?>"
                        alt="Logo de l'INBTP" title="Institut National du Bâtiment et des Travaux Publics"
                        class="h-auto sm:w-12 w-8">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.ulc-icam.com/" target="_blank" title="Université Loyola du Congo">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-ulc.png') ?>"
                        alt="Logo de l'ULC-Icam" title="Université Loyola du Congo" class="h-auto sm:w-36 w-16">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.ulc-icam.com/" target="_blank" title="Haute Ecole de Commerce de Kinshasa">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-hec.png') ?>"
                        alt="Logo de la Haute Ecole de Commerce de Kinshasa" title="Haute Ecole de Commerce de Kinshasa"
                        class="h-auto sm:w-18 w-12">
                </a>
                <!-- End Kinshasa -->

                <!-- Kasai -->
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200" href="#"
                    title="Université Notre Dame du Kasai">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-uka.png') ?>"
                        alt="Logo de l'Université Notre Dame du Kasai" title="Université Notre Dame du Kasai"
                        class="h-auto sm:w-16 w-14">
                </a>
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200" href="#"
                    title="Université Officielle de Mbuji-Mayi">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-uom.png') ?>"
                        alt="Logo de l'Université Officielle de Mbuji-Mayi" title="Université Officielle de Mbuji-Mayi"
                        class="h-auto sm:w-16 w-14">
                </a>
                <a href="https://universitemapon.ac.cd/" class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    title="Université Mapon">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-mapon.png') ?>"
                        alt="Logo de l'Université Mapon" title="Université Mapon"
                        class="h-auto sm:w-16 w-14">
                </a>

                <!-- Katanga -->
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://upl-univ.ac/" title="Université Protestante de Lubumbashi">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-upl.png') ?>"
                        alt="Logo de l'Université Protestante de Lubumbashi"
                        title="Université Protestante de Lubumbashi" class="h-auto sm:w-14 w-12">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://esisalama.netlify.app/" title="École supérieure d'informatique Salama">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-esis-salama.png') ?>"
                        alt="Logo de l'École supérieure d'informatique Salama"
                        title="École supérieure d'informatique Salama" class="h-auto sm:w-14 w-12">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.unilu.ac.cd/" title="Université de Lubumbashi">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unilu.png') ?>"
                        alt="Logo de l'Université de Lubumbashi" title="Université de Lubumbashi"
                        class="h-auto sm:w-16 w-14">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://unikol.ac/index.php" title="Université de Kolwezi">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unikol.png') ?>"
                        alt="Logo de l'Université de Kolwezi" title="Université de Kolwezi"
                        class="h-auto sm:w-16 w-14">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.unhorizons.org/" title="Université Nouveaux Horizons">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unh.png') ?>"
                        alt="Logo de l'Université Nouveaux Horizons" title="Université Nouveaux Horizons"
                        class="h-auto sm:w-20 w-16">
                </a>
                <!-- End Katanga -->
                <!-- P.O -->
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://unikis.net/" title="Université de Kisangani">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unikis.png') ?>"
                        alt="Logo de l'Université de Kisangani"
                        title="Université de Kisangani" class="h-auto sm:w-24 w-20">
                </a>
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://unishabunia.org/" title="Université Shalom de Bunia">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-usb.png') ?>"
                        alt="Logo de l'Université Shalom de Bunia"
                        title="Université Shalom de Bunia" class="h-auto sm:w-16 w-14">
                </a>
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="#" title="Institut Supérieur Pédagogique de Kisangani">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-isp-kisangani.png') ?>"
                        alt="Logo de l'Institut Supérieur Pédagogique de Kisangani"
                        title="Institut Supérieur Pédagogique de Kisangani" class="h-auto sm:w-20 w-16">
                </a>
                <!-- End P.O -->

                <!-- Nord Kivu -->
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://ulpgl.net/" title="Université Libre des Pays des Grands Lacs">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-ulpgl.png') ?>"
                        alt="Logo de l'Université Libre des Pays des Grands Lacs"
                        title="Université Libre des Pays des Grands Lacs" class="h-auto sm:w-24 w-20">
                </a>
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://isig.ac.cd/" title="Institut Supérieur d'Informatique et de Gestion">
                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-isig.png') ?>"
                        alt="Logo de l'Institut Supérieur d'Informatique et de Gestion"
                        title="Institut Supérieur d'Informatique et de Gestion" class="h-auto sm:w-16 w-14">
                </a>
                <!-- End Nord Kivu -->

                <!-- Sud Kivu -->
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://uob.ac.cd/" title="Université Officielle de Bukavu">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-uob.png') ?>"
                        alt="Logo de l'Université Officielle de Bukavu" title="Université Officielle de Bukavu"
                        class="h-auto sm:w-24 w-20">
                </a>
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://ucbukavu.ac.cd/" title="Université Catholique de Bukavu">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-ucb.png') ?>"
                        alt="Logo de l'Université Catholique de Bukavu" title="Université Catholique de Bukavu"
                        class="h-auto sm:w-24 w-20">
                </a>
                <!-- End Sud Kivu -->
                <!-- Kongo Central -->
                 <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200" href="#"
                    title="Université Libre de Matadi">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-unimat.png') ?>"
                        alt="Logo de l'Université Libre de Matadi" title="Université Libre de Matadi" class="h-auto sm:w-24 w-20">
                </a>

                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://universitekongo.cd/" title="Université de Kongo">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-uni-kongo.png') ?>"
                        alt="Logo de l'Université de Kongo" title="Université de Kongo"
                        class="h-auto sm:w-24 w-20">
                </a>
                
                <a class="animate-bounce flex items-center justify-center text-gray-400 hover:text-gray-200"
                    href="https://www.groupe-horeb.net/" title="Université Technologique Horeb">

                    <img src="<?= new moodle_url('/local/scholarship/assets/img/logo-uni-horeb.png') ?>"
                        alt="Logo de l'Université Technologique Horeb" title="Université Technologique Horeb"
                        class="h-auto sm:w-20 w-16">
                </a>

            </div>
        </div>
    </section>
    <!-- End Partners Section -->

    <div class="scholarship-wave-divider">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- Contact Section -->
    <section class="bg-white/70 py-20 backdrop-blur-sm" id="scholarship-contact">
        <div class="scholarship-shell">
            <div class="text-center">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">
                    <?php echo get_string('home:contact_title', 'local_scholarship'); ?>
                </h2>
                <p class="mx-auto mt-4 max-w-3xl text-md md:text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:contact_description', 'local_scholarship'); ?>
                </p>
            </div>
            <div class="mt-12 grid gap-3 md:gap-6 lg:grid-cols-3">

                <!-- Email -->
                <article
                    class="group rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                    <div
                        class="animate-bounce mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:h-8 w-6 md:w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 7.5v9A2.25 2.25 0 0119.5 18.75h-15A2.25 2.25 0 012.25 16.5v-9m19.5 0L12 13.5 2.25 7.5m19.5 0A2.25 2.25 0 0019.5 5.25h-15A2.25 2.25 0 002.25 7.5" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-md md:text-xl font-bold text-slate-900">
                        <?php echo get_string('home:contact_email', 'local_scholarship'); ?>
                    </h3>

                    <a href="mailto:fondation@vodacom.cd"
                        class="mt-3 block text-md md:text-lg font-semibold text-red-600 hover:underline">
                        fondation@vodacom.cd
                    </a>
                </article>

                <!-- Téléphone -->
                <article
                    class="group rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                    <div
                        class="animate-pulse mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:h-8 w-6 md:w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372a1.5 1.5 0 00-1.09-1.443l-4.423-1.106a1.5 1.5 0 00-1.465.487l-.97 1.164a1.5 1.5 0 01-1.61.46A12.035 12.035 0 016.71 11.81a1.5 1.5 0 01.46-1.61l1.164-.97a1.5 1.5 0 00.487-1.465L7.715 3.34A1.5 1.5 0 006.272 2.25H4.9A2.25 2.25 0 002.65 4.5v2.25z" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-md md:text-xl font-bold text-slate-900">
                        <?php echo get_string('home:contact_phone', 'local_scholarship'); ?>
                    </h3>

                    <a href="tel:+243824444444"
                        class="mt-3 block text-md md:text-lg font-semibold text-red-600 hover:underline">
                        +243 815 560 508
                    </a>
                </article>

                <!-- Adresse -->
                <article
                    class="group rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-lg transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
                    <div
                        class="animate-bounce mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:h-8 w-6 md:w-8" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.5-7.5 11.25-7.5 11.25S4.5 18 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                    </div>

                    <h3 class="mt-5 text-md md:text-xl font-bold text-slate-900">
                        <?php echo get_string('home:contact_address', 'local_scholarship'); ?>
                    </h3>

                    <p class="mt-3 text-base leading-relaxed text-slate-600">
                        <?php echo get_string('home:contact_address_value', 'local_scholarship'); ?>
                    </p>
                </article>

            </div>
            <div
                class="mt-8 flex min-h-72 items-center justify-center rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 text-slate-500">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3978.5717519984055!2d15.309259640207772!3d-4.303017900000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a33001419536d%3A0x71f18e09c45f198f!2sVodacom%20DRC%20-%20VodaPark!5e0!3m2!1sfr!2scd!4v1775229829430!5m2!1sfr!2scd"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg>
    </div>

    <!-- FAQ Section -->
    <section class="py-20">
        <div class="scholarship-shell">
            <div class="scholarship-surface p-8 md:p-10">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                        <?php echo get_string('home:faq_title', 'local_scholarship'); ?>
                    </h2>
                    <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:faq_description', 'local_scholarship'); ?>
                    </p>
                </div>
                <div class="mx-auto mt-10 max-w-4xl divide-y divide-slate-200">
                    <?php foreach ($faqitems as $item): ?>
                        <details class="group py-5">
                            <summary
                                class="flex cursor-pointer items-center justify-between gap-6 text-left text-md md:text-lg font-semibold text-slate-800">
                                <span><?php echo s($item['question']); ?></span>
                                <span
                                    class="animate-bounce text-slate-400 transition duration-200 group-open:rotate-180">⌄</span>
                            </summary>
                            <p class="mt-4 text-sm md:text-base leading-8 text-slate-600"><?php echo s($item['answer']); ?>
                            </p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- End FAQ Section -->
</div>