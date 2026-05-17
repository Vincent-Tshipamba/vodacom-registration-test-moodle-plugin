<?php
$heroimage = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvARcp_7T2jbszuz8AFGf7k9cQMY4atBoEKg&s';
$registerurl = new moodle_url('/login/signup.php');
$learnmoreurl = new moodle_url('/login/index.php');

$stats = [
    ['count' => '500+', 'description' => get_string('home:stat1_desc', 'local_scholarship')],
    ['count' => '100%', 'description' => get_string('home:stat2_desc', 'local_scholarship')],
    ['count' => '50+', 'description' => get_string('home:stat3_desc', 'local_scholarship')],
];

$whatisitcards = [
    ['title' => get_string('home:what1_title', 'local_scholarship'), 'description' => get_string('home:what1_desc', 'local_scholarship')],
    ['title' => get_string('home:what2_title', 'local_scholarship'), 'description' => get_string('home:what2_desc', 'local_scholarship')],
    ['title' => get_string('home:what3_title', 'local_scholarship'), 'description' => get_string('home:what3_desc', 'local_scholarship')],
    ['title' => get_string('home:what4_title', 'local_scholarship'), 'description' => get_string('home:what4_desc', 'local_scholarship')],
];

$conditions = [
    get_string('home:condition1', 'local_scholarship'),
    get_string('home:condition2', 'local_scholarship'),
    get_string('home:condition3', 'local_scholarship'),
    get_string('home:condition4', 'local_scholarship'),
    get_string('home:condition5', 'local_scholarship'),
    get_string('home:condition6', 'local_scholarship'),
    get_string('home:condition7', 'local_scholarship'),
];

$processsteps = [
    ['number' => '01', 'title' => get_string('home:process1_title', 'local_scholarship'), 'description' => get_string('home:process1_desc', 'local_scholarship')],
    ['number' => '02', 'title' => get_string('home:process2_title', 'local_scholarship'), 'description' => get_string('home:process2_desc', 'local_scholarship')],
    ['number' => '03', 'title' => get_string('home:process3_title', 'local_scholarship'), 'description' => get_string('home:process3_desc', 'local_scholarship')],
    ['number' => '04', 'title' => get_string('home:process4_title', 'local_scholarship'), 'description' => get_string('home:process4_desc', 'local_scholarship')],
    ['number' => '05', 'title' => get_string('home:process5_title', 'local_scholarship'), 'description' => get_string('home:process5_desc', 'local_scholarship')],
];

$testimonials = [
    ['name' => 'Grâce M.', 'role' => get_string('home:testimonial1_role', 'local_scholarship'), 'text' => get_string('home:testimonial1_text', 'local_scholarship')],
    ['name' => 'Junior K.', 'role' => get_string('home:testimonial2_role', 'local_scholarship'), 'text' => get_string('home:testimonial2_text', 'local_scholarship')],
    ['name' => 'Sarah T.', 'role' => get_string('home:testimonial3_role', 'local_scholarship'), 'text' => get_string('home:testimonial3_text', 'local_scholarship')],
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
];
?>
<div class="scholarship-home scholarship-home-bg">
    <section class="relative isolate flex min-h-screen items-center overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo s($heroimage); ?>');"></div>
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
            <div class="flex md:flex-row flex-col gap-4">
                <a class="transform animate-bounce rounded-full bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 px-8 py-4 text-lg font-semibold text-white no-underline shadow-lg transition duration-300 ease-in-out hover:scale-105 hover:text-white hover:no-underline focus:text-white focus:no-underline active:text-white active:no-underline"
                    href="<?php echo $registerurl; ?>"><?php echo get_string('home:cta_apply', 'local_scholarship'); ?></a>
                <a class="rounded-full border-2 border-white px-8 py-4 text-lg font-semibold text-white no-underline transition duration-300 ease-in-out hover:bg-white hover:!text-slate-900 hover:no-underline focus:!text-slate-900 focus:no-underline active:!text-slate-900 active:no-underline"
                    href="<?php echo $learnmoreurl; ?>"><?php echo get_string('home:learn_more', 'local_scholarship'); ?></a>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="scholarship-shell text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                <?php echo get_string('home:stats_title', 'local_scholarship'); ?></h2>
            <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                <?php echo get_string('home:stats_description', 'local_scholarship'); ?></p>
            <div class="mt-14 grid gap-6 lg:grid-cols-3">
                <?php foreach ($stats as $stat): ?>
                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-8 text-center shadow-[0_24px_60px_rgba(15,23,42,0.10)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(15,23,42,0.14)]">
                        <strong
                            class="block text-4xl font-black tracking-tight text-slate-900"><?php echo s($stat['count']); ?></strong>
                        <span
                            class="mt-3 block text-base leading-7 text-slate-600"><?php echo s($stat['description']); ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
            preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="bg-white/70 py-20 backdrop-blur-sm" id="what-is-it">
        <div class="scholarship-shell">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                    <?php echo get_string('home:what_title', 'local_scholarship'); ?></h2>
                <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:what_description', 'local_scholarship'); ?></p>
            </div>
            <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                <?php foreach ($whatisitcards as $card): ?>
                    <article
                        class="rounded-3xl border border-slate-200/80 bg-white p-7 shadow-[0_24px_60px_rgba(15,23,42,0.10)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_28px_70px_rgba(15,23,42,0.14)]">
                        <h3 class="text-xl font-bold text-slate-900"><?php echo s($card['title']); ?></h3>
                        <p class="mt-3 text-base leading-7 text-slate-600"><?php echo s($card['description']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="py-20">
        <div class="scholarship-shell">
            <div class="scholarship-surface p-8 md:p-10">
                <div>
                    <span
                        class="inline-flex rounded-full border border-red-200 bg-red-50 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-red-600"><?php echo get_string('home:conditions_badge', 'local_scholarship'); ?></span>
                    <h2 class="mt-5 text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                        <?php echo get_string('home:conditions_title', 'local_scholarship'); ?></h2>
                    <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:conditions_description', 'local_scholarship'); ?></p>
                </div>
                <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    <?php foreach ($conditions as $condition): ?>
                        <article
                            class="flex gap-4 rounded-[1.5rem] border border-slate-200/80 bg-white p-5 shadow-[0_20px_50px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">
                            <span
                                class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 font-bold text-red-600">✓</span>
                            <p class="text-base leading-7 text-slate-700"><?php echo s($condition); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="mt-8 border-t border-slate-200 pt-6">
                    <strong
                        class="block text-sm font-bold uppercase tracking-[0.16em] text-red-700"><?php echo get_string('home:important', 'local_scholarship'); ?></strong>
                    <p class="mt-3 text-base leading-8 text-slate-600">
                        <?php echo get_string('home:conditions_note', 'local_scholarship'); ?></p>
                </div>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
            preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="bg-white/70 py-20 backdrop-blur-sm">
        <div class="scholarship-shell">
            <div class="scholarship-surface p-8 md:p-10">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                        <?php echo get_string('home:process_title', 'local_scholarship'); ?></h2>
                    <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:process_description', 'local_scholarship'); ?></p>
                </div>
                <div class="mt-12 grid gap-6 xl:grid-cols-5 md:grid-cols-2">
                    <?php foreach ($processsteps as $step): ?>
                        <article
                            class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 text-center shadow-[0_20px_50px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">
                            <div
                                class="mx-auto mb-5 inline-flex h-16 w-16 items-center justify-center rounded-full border border-red-200 text-xl font-black tracking-[0.18em] text-red-600">
                                <?php echo s($step['number']); ?></div>
                            <h3 class="text-xl font-bold text-slate-900"><?php echo s($step['title']); ?></h3>
                            <p class="mt-3 text-base leading-7 text-slate-600"><?php echo s($step['description']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="py-20">
        <div class="scholarship-shell">
            <div
                class="scholarship-surface grid items-center gap-8 p-8 md:p-10 lg:grid-cols-[minmax(0,1fr)_minmax(320px,0.9fr)]">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">
                        <?php echo get_string('home:cta_title', 'local_scholarship'); ?></h2>
                    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:cta_description', 'local_scholarship'); ?></p>
                    <div class="mt-8">
                        <a class="scholarship-btn scholarship-btn--primary"
                            href="<?php echo $registerurl; ?>"><?php echo get_string('home:cta_button', 'local_scholarship'); ?></a>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-5 md:grid-rows-4">
                    <div
                        class="min-h-28 rounded-3xl bg-gradient-to-br from-red-200/70 via-red-100 to-white md:col-span-2 md:row-span-4">
                    </div>
                    <div
                        class="min-h-28 rounded-3xl bg-gradient-to-br from-slate-200 to-white md:col-span-3 md:row-span-2">
                    </div>
                    <div
                        class="min-h-28 rounded-3xl bg-gradient-to-br from-rose-100 to-white md:col-span-3 md:row-span-2">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
            preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="bg-white/70 py-20 backdrop-blur-sm" id="testimonials-section">
        <div class="scholarship-shell">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                    <?php echo get_string('home:testimonials_title', 'local_scholarship'); ?></h2>
                <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:testimonials_description', 'local_scholarship'); ?></p>
            </div>
            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                <?php foreach ($testimonials as $testimonial): ?>
                    <article
                        class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 text-center shadow-[0_20px_50px_rgba(15,23,42,0.08)] transition duration-200 hover:-translate-y-1 hover:shadow-[0_24px_60px_rgba(15,23,42,0.12)]">
                        <div
                            class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-red-600 to-rose-400 text-lg font-black text-white">
                            <?php echo s(core_text::substr($testimonial['name'], 0, 1)); ?></div>
                        <h3 class="mt-5 text-xl font-bold text-slate-900"><?php echo s($testimonial['name']); ?></h3>
                        <span
                            class="mt-2 block text-sm font-medium text-slate-500"><?php echo s($testimonial['role']); ?></span>
                        <p class="mt-4 text-base leading-7 text-slate-600"><?php echo s($testimonial['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="bg-slate-900 py-20 text-white">
        <div class="scholarship-shell text-center">
            <h2 class="text-3xl font-bold tracking-tight md:text-4xl">
                <?php echo get_string('home:partners_title', 'local_scholarship'); ?></h2>
            <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-300">
                <?php echo get_string('home:partners_description', 'local_scholarship'); ?></p>
            <div class="mt-12 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <?php foreach ($partners as $partner): ?>
                    <div class="rounded-3xl border border-white/10 bg-white/5 px-5 py-6 font-semibold text-slate-100">
                        <?php echo s($partner); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <div class="scholarship-wave-divider"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
            preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="bg-white/70 py-20 backdrop-blur-sm" id="scholarship-contact">
        <div class="scholarship-shell">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                    <?php echo get_string('home:contact_title', 'local_scholarship'); ?></h2>
                <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                    <?php echo get_string('home:contact_description', 'local_scholarship'); ?></p>
            </div>
            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                <article
                    class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 text-center shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
                    <h3 class="text-xl font-bold text-slate-900">
                        <?php echo get_string('home:contact_email', 'local_scholarship'); ?></h3>
                    <p class="mt-3 text-base text-slate-600">fondation@vodacom.cd</p>
                </article>
                <article
                    class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 text-center shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
                    <h3 class="text-xl font-bold text-slate-900">
                        <?php echo get_string('home:contact_phone', 'local_scholarship'); ?></h3>
                    <p class="mt-3 text-base text-slate-600">+243 000 000 000</p>
                </article>
                <article
                    class="rounded-[1.75rem] border border-slate-200/80 bg-white p-7 text-center shadow-[0_20px_50px_rgba(15,23,42,0.08)]">
                    <h3 class="text-xl font-bold text-slate-900">
                        <?php echo get_string('home:contact_address', 'local_scholarship'); ?></h3>
                    <p class="mt-3 text-base text-slate-600">
                        <?php echo get_string('home:contact_address_value', 'local_scholarship'); ?></p>
                </article>
            </div>
            <div
                class="mt-8 flex min-h-72 items-center justify-center rounded-[2rem] border border-dashed border-slate-300 bg-slate-50 text-slate-500">
                <?php echo get_string('home:map_placeholder', 'local_scholarship'); ?></div>
        </div>
    </section>

    <div class="scholarship-wave-divider scholarship-wave-divider--reverse"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z">
            </path>
        </svg></div>

    <section class="py-20">
        <div class="scholarship-shell">
            <div class="scholarship-surface p-8 md:p-10">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-4xl">
                        <?php echo get_string('home:faq_title', 'local_scholarship'); ?></h2>
                    <p class="mx-auto mt-4 max-w-3xl text-lg leading-8 text-slate-600">
                        <?php echo get_string('home:faq_description', 'local_scholarship'); ?></p>
                </div>
                <div class="mx-auto mt-10 max-w-4xl divide-y divide-slate-200">
                    <?php foreach ($faqitems as $item): ?>
                        <details class="group py-5">
                            <summary
                                class="flex cursor-pointer items-center justify-between gap-6 text-left text-lg font-semibold text-slate-800">
                                <span><?php echo s($item['question']); ?></span>
                                <span class="text-slate-400 transition duration-200 group-open:rotate-180">⌄</span>
                            </summary>
                            <p class="mt-4 text-base leading-8 text-slate-600"><?php echo s($item['answer']); ?></p>
                        </details>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>