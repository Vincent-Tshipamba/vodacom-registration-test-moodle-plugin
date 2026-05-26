<?php
require(__DIR__ . '/../partials/values_for_registration.php');
?>

<div class="scholarship-shell max-w-5xl">
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="<?php echo $homeurl; ?>"
                class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 no-underline transition hover:text-red-700 hover:no-underline">
                <span aria-hidden="true">&larr;</span>
                <span><?php echo get_string('back_home', 'local_scholarship'); ?></span>
            </a>
            <h1 class="mt-4 text-xl font-black tracking-tight text-slate-900 md:text-3xl">
                <?php echo get_string('apply_title', 'local_scholarship'); ?>
            </h1>
        </div>
    </div>

    <div class="bg-slate-100  pb-24 min-h-screen text-slate-900 ">
        <form action="<?= new moodle_url('/local/scholarship/apply.php') ?>" id="registrationForm" class="space-y-10" x-data="app()" x-init="init()" @submit="submitForm($event)"
            x-cloak>
            <input type="hidden" name="sesskey" value="<?php echo sesskey(); ?>">
            <div class="mx-auto px-4 py-10 max-w-4xl">
                <div id="form-global-error" x-show="errors.general" x-text="errors.general"
                    class="bg-red-50 mb-4 p-4 rounded-md text-red-700 text-sm" style="display: none;">
                </div>

                <!-- Confirmation Message -->
                <div x-show.transition="step === 'complete'" id="confirmation" tabindex="-1" role="status"
                    aria-live="polite">
                    <div class="bg-white  shadow-lg p-10 rounded-lg text-center">
                        <div
                            class="flex justify-center items-center bg-green-100  mx-auto mb-6 rounded-full w-20 h-20">
                            <svg class="w-12 h-12 text-green-500 " fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h2 class="mb-2 font-bold text-2xl">
                            <?= get_string('apply_confirmation_title', 'local_scholarship'); ?>
                        </h2>
                        <p id="confirmation_message" class="mb-6 text-gray-600 ">
                            <?= get_string('apply_confirmation_message', 'local_scholarship'); ?>
                        </p>
                        <p id="confirmation_details" class="mb-8 text-gray-500  text-sm">
                            
                        </p>

                        <div id="confirmation_coupon_block" class="bg-gray-100  mb-6 p-4 rounded-lg">
                            <p class="mb-1 text-gray-500  text-sm">
                                <?= get_string('apply_confirmation_coupon', 'local_scholarship'); ?>
                            </p>
                            <div class="flex justify-center items-center space-x-2">
                                <input type="hidden" id="confirmation_coupon_input" value="1234">
                                <p id="confirmation_coupon"
                                    class="font-mono font-bold text-gray-800 -xl">
                                    
                                </p>
                                <button type="button" data-copy-to-clipboard-target="confirmation_coupon_input"
                                    data-tooltip-target="tooltip-copy-confirmation-coupon-button"
                                    data-tooltip-placement="right"
                                    class="flex items-center bg-white hover:bg-white/50  -800/50 mt-7 px-3 py-1.5 border border-default-strong  focus:outline-none focus:ring-4 focus:ring-neutral-tertiary-soft font-medium text-body hover:text-heading  text-xs leading-5 -translate-y-1/2 end-1.5">
                                    <span id="default-message">
                                        <span class="flex items-center">
                                            <svg class="me-1.5 w-4 h-4" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 5h6m-6 4h6M10 3v4h4V3h-4Z" />
                                            </svg>
                                            <span
                                                class="font-semibold text-xs"><?= get_string('copy', 'local_scholarship'); ?></span>
                                        </span>
                                    </span>
                                    <span id="success-message" class="hidden">
                                        <span class="flex items-center">
                                            <svg class="me-1.5 w-4 h-4 text-fg-brand text-green-500" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                                            </svg>
                                            <span
                                                class="font-semibold text-green-600 text-xs"><?= get_string('copied', 'local_scholarship'); ?></span>
                                        </span>
                                    </span>
                                </button>
                                <div id="tooltip-copy-confirmation-coupon-button" role="tooltip"
                                    class="invisible inline-block z-10 absolute bg-white  shadow-xs px-3 py-2 rounded-base font-medium text-gray-700  text-sm transition-opacity duration-300 tooltip">
                                    <span
                                        id="default-tooltip-message"><?= get_string('copy_label', 'local_scholarship'); ?></span>
                                    <span id="success-tooltip-message"
                                        class="hidden"><?= get_string('copied', 'local_scholarship'); ?></span>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                        <a href="<?= $homeurl; ?>"
                            class="inline-block bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded-lg font-bold text-white transition duration-200">
                            <?= get_string('back_home', 'local_scholarship'); ?>
                        </a>
                    </div>
                </div>

                <!-- Form steps -->
                <div x-show.transition="step != 'complete'">
                    <!-- Top Navigation -->
                    <div class="py-3 border-b-2">
                        <div><?= get_string('step', 'local_scholarship') ?> <span x-text="step"></span>
                            <?= get_string('of', 'local_scholarship') ?> 5
                        </div>

                        <div class="flex md:flex-row flex-col md:justify-between md:items-center">
                            <div class="flex-1">
                                <div x-show="step === 1">
                                    <div class="font-bold text-lg leading-tight">
                                        <?php echo get_string('apply_step_1_title', 'local_scholarship'); ?>
                                    </div>
                                </div>

                                <div x-show="step === 2">
                                    <div class="font-bold text-lg leading-tight">
                                        <?php echo get_string('apply_step_2_title', 'local_scholarship'); ?>
                                    </div>
                                </div>

                                <div x-show="step === 3">
                                    <div class="font-bold text-lg leading-tight">
                                        <?php echo get_string('apply_step_3_title', 'local_scholarship'); ?>
                                    </div>
                                </div>

                                <div x-show="step === 4">
                                    <div class="font-bold text-lg leading-tight">
                                        <?php echo get_string('apply_step_4_title', 'local_scholarship'); ?>
                                    </div>
                                </div>

                                <div x-show="step === 5">
                                    <div class="font-bold text-lg leading-tight">
                                        <?php echo get_string('apply_step_5_title', 'local_scholarship'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center md:w-64">
                                <div class="bg-white mr-2 rounded-full w-full">
                                    <div class="bg-green-500 rounded-full h-2 text-xs text-center leading-none"
                                        :style="'width: ' + parseInt(step / 5 * 100) + '%'"></div>
                                </div>
                                <div class="w-10 text-xs" x-text="parseInt(step / 5 * 100) +'%'"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Top Navigation  -->
                    <!-- Step content -->
                    <div class="bg-white  shadow-md mb-6 p-8 rounded-lg">
                        <!-- Step 1: Personal Information -->
                        <div x-show.transition.in="step === 1">
                            <!-- Photo Upload -->
                            <div class="mb-5 text-center">
                                <div
                                    class="relative bg-gray-100 shadow-inset mx-auto mb-2 border rounded-full w-32 h-32">
                                    <img id="image" class="rounded-full w-full h-32 object-cover" :src="image" />
                                </div>
                                <label for="photo" type="button"
                                    class="inline-flex justify-between items-center bg-white hover:bg-gray-100  -700 shadow-sm px-4 py-2 border rounded-lg focus:outline-none font-medium text-gray-600  text-left cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="inline-flex flex-shrink-0 -mt-1 mr-1 w-6 h-6" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <path
                                            d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                                        <circle cx="12" cy="13" r="3" />
                                    </svg>
                                    <?= get_string('apply_browse_photo', 'local_scholarship') ?><span
                                        class="text-red-500">*</span>
                                </label>
                                <div class="mx-auto mt-1 w-48 text-gray-500 text-xs text-center">
                                    <?php echo get_string('apply_browse_photo_label', 'local_scholarship'); ?>
                                </div>
                                <p x-show="errors.photo" class="mt-1 text-red-500 text-sm" x-text="errors.photo"></p>

                                <input name="photo" id="photo" accept="image/*" class="hidden" type="file"
                                    data-error-required="<?= get_string('validation_photo_required', 'local_scholarship') ?>"
                                    data-error-size="<?= get_string('validation_file_size', 'local_scholarship') ?>"
                                    data-error-type="<?= get_string('validation_file_type', 'local_scholarship') ?>"
                                    @change="let file = document.getElementById('photo').files[0];
                                    var reader = new FileReader();
                                    reader.onload = (e) => image = e.target.result;
                                    reader.readAsDataURL(file);formData.photo = $event.target.files[0]">
                            </div>
                            <!-- Personal Info Form -->
                            <div class="gap-4 grid md:grid-cols-2">
                                <!-- Full Name -->
                                <div>
                                    <label for="fullname" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_input_fullname_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="fullname" name="fullname" x-model="formData.fullname"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        :class="{ 'border-red-500': errors.fullname }"
                                        data-error-required="<?= get_string('validation_fullname_required', 'local_scholarship') ?>"
                                        placeholder="<?= get_string('apply_input_fullname_placeholder', 'local_scholarship') ?>">
                                    <p x-show="errors.fullname" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.fullname"></p>
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label for="phone" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_input_phone_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="left-0 absolute inset-y-0 flex items-center pl-3 pointer-events-none">
                                            <span class="text-gray-500">+243</span>
                                        </div>
                                        <input type="tel" id="phone" name="phone"
                                            x-model="formData.phone" inputmode="tel" maxlength="9"
                                            pattern="8[0-3][0-9]{7}" @input="handlePhoneNumberInput()"
                                            @blur="validatePhoneNumberField()"
                                            class=" py-2 pr-4 pl-16 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                            :class="{ 'border-red-500': errors.phone }"
                                            data-error-phone-regex="<?= get_string('validation_phone_regex', 'local_scholarship') ?>"
                                            data-error-phone="<?= get_string('validation_phone_invalid', 'local_scholarship') ?>"
                                            data-error-required="<?= get_string('validation_phone_required', 'local_scholarship') ?>"
                                            placeholder="<?= get_string('apply_phone_placeholder', 'local_scholarship') ?>">
                                    </div>
                                    <p x-show="errors.phone" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.phone">
                                    </p>
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label class="block mb-2 font-medium text-sm">
                                        <?= get_string('apply_input_gender_label', 'local_scholarship') ?> <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex space-x-4">
                                        <?php foreach ($genders as $value => $label): ?>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="gender" value="<?= $value ?>"
                                                        x-model="formData.gender"
                                                        class="w-4 h-4 text-red-600 border-4 border-gray-200 focus:ring-red-500">
                                                    <span class="ml-2"><?= $label ?></span>
                                                </label>
                                        <?php endforeach; ?>
                                    </div>
                                    <p x-show="errors.gender" class="mt-1 text-red-500 text-sm" x-text="errors.gender">
                                    </p>
                                </div>

                                <!-- Birthdate -->
                                <div>
                                    <label for="birthdate" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_input_birthdate_label', 'local_scholarship') ?><span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="birthdate" name="birthdate"
                                        x-model="formData.birthdate" @change="calculateAge"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        :class="{ 'border-red-500': errors.birthdate }"
                                        data-error-required="<?= get_string('validation_birthdate_required', 'local_scholarship') ?>"
                                        data-error-age="<?= get_string('validation_age_requirement', 'local_scholarship') ?>">
                                    <p x-show="errors.birthdate" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.birthdate"></p>
                                </div>

                                <!-- Type d'identification -->
                                <div>
                                    <label class="block mb-2 font-medium text-sm">
                                        <?= get_string('apply_vulnerability_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-2">
                                        <?php foreach ($vulnerabilities as $value => $label): ?>
                                                <div class="flex items-center">
                                                    <input type="radio" id="<?= $value ?>"
                                                        name="vulntype" value="<?= $value ?>"
                                                        x-model="formData.vulntype"
                                                        class=" w-4 h-4 text-red-600 border-4 border-gray-200 focus:ring-red-500"
                                                        <?php if ($value === 'NONE'): ?>
                                                            checked 
                                                        <?php endif; ?>
                                                    >
                                                    <label for="<?= $value ?>" class="block ml-2 text-sm">
                                                        <?= $label ?>
                                                    </label>
                                                </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <p x-show="errors.vulntype" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.vulntype"></p>
                                </div>

                                <!-- Age (auto-calculated) -->
                                <div x-show="formData.birthdate">
                                    <label class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_age_label', 'local_scholarship') ?>
                                    </label>
                                    <div class="bg-gray-100  px-4 py-2 rounded-lg">
                                        <span
                                            x-text="formData.age + ' ' + '<?= get_string('apply_years_old', 'local_scholarship') ?>'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Address Information -->
                        <div x-show.transition.in="step === 2">
                            <div class="gap-4 grid md:grid-cols-2">
                                <!-- Current City -->
                                <div class="md:col-span-2">
                                    <label for="currentcityid" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_current_city_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <select id="currentcityid" name="currentcityid"
                                        x-model="formData.currentcityid"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full "
                                        :class="{ 'border-red-500': errors.currentcityid }"
                                        data-error-exists="<?= get_string('validation_current_city_exists', 'local_scholarship') ?>"
                                        data-error-required="<?= get_string('validation_current_city_required', 'local_scholarship') ?>"
                                        required>
                                        <option value="">
                                            <?= get_string('apply_current_city_placeholder', 'local_scholarship') ?>
                                        </option>
                                        <?php foreach ($cities as $city): ?>
                                                <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p x-show="errors.currentcityid" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.currentcityid"></p>
                                </div>
                                <!-- Diploma City -->
                                <div class="md:col-span-2">
                                    <label for="diplomacityid" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_educational_city_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <select id="diplomacityid" name="diplomacityid"
                                        x-model="formData.diplomacityid"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full"
                                        :class="{ 'border-red-500': errors.diplomacityid }"
                                        data-error-exists="<?= get_string('validation_educational_city_exists', 'local_scholarship') ?>"
                                        data-error-required="<?= get_string('validation_educational_city_required', 'local_scholarship') ?>"
                                        required>
                                        <option value="">
                                            <?= get_string('apply_educational_city_placeholder', 'local_scholarship') ?>
                                        </option>
                                        <?php foreach ($cities as $city): ?>
                                            <option value="<?= $city->id ?>"><?= $city->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="mt-1 text-gray-500  text-xs">
                                        <?= get_string('apply_educational_city_help', 'local_scholarship') ?>
                                    </p>
                                    <p x-show="errors.diplomacityid"
                                        class="mt-1 text-red-500 text-sm"
                                        x-text="errors.diplomacityid"></p>
                                </div>
                                <!-- Full Address -->
                                <div class="md:col-span-2">
                                    <label for="address" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_input_address_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <textarea id="address" name="address" rows="3" x-model="formData.address"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        :class="{ 'border-red-500': errors.address }"
                                        data-error-required="<?= get_string('validation_address_required', 'local_scholarship') ?>"
                                        placeholder="<?= get_string('apply_input_address_placeholder', 'local_scholarship') ?>"></textarea>
                                    <p x-show="errors.address" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.address"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Step 3: Academic Information -->
                        <div x-show.transition.in="step === 3">
                            <div class="gap-4 grid md:grid-cols-2">
                                <!-- School Name -->
                                <div class="md:col-span-2">
                                    <label for="schoolname" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_schoolname_label', 'local_scholarship') ?> <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="schoolname" name="schoolname"
                                        x-model="formData.schoolname"
                                        data-error-required="<?= get_string('validation_schoolname_required', 'local_scholarship') ?>"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        :class="{ 'border-red-500': errors.schoolname }"
                                        placeholder="<?= get_string('apply_schoolname_placeholder', 'local_scholarship') ?>">
                                    <p x-show="errors.schoolname" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.schoolname"></p>
                                </div>
                                <!-- Study Option -->
                                <div>
                                    <label for="schoolfield" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_study_option_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <select id="schoolfield" name="schoolfield"
                                        x-model="formData.schoolfield"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full"
                                        :class="{ 'border-red-500': errors.schoolfield }"
                                        data-error-required="<?= get_string('validation_study_option_required', 'local_scholarship') ?>" required>
                                        <option value="">
                                            <?= get_string('apply_study_option_placeholder', 'local_scholarship') ?>
                                        </option>
                                        <?php foreach ($study_options as $value => $label): ?>
                                                <option value="<?= $value ?>"><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p x-show="errors.schoolfield" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.schoolfield"></p>
                                </div>
                                <div x-show="formData.schoolfield === 'other'" class="mt-2" x-transition>
                                    <label for="other_study_option" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_other_study_option_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="other_study_option" name="other_study_option"
                                        x-model="formData.other_study_option"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        :class="{ 'border-red-500': errors.other_study_option }"
                                        data-error-required="<?= get_string('validation_required', 'local_scholarship') ?>"
                                        placeholder="<?= get_string('apply_other_study_option_placeholder', 'local_scholarship') ?>">
                                    <p x-show="errors.other_study_option" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.other_study_option"></p>
                                </div>
                                <!-- Diploma Score -->
                                <div>
                                    <label for="percentage" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_percentage_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="percentage" name="percentage"
                                            x-model="formData.percentage" min="50" max="100" maxlength="3"
                                            pattern="\d{2,3}" step="1" inputmode="numeric"
                                            @input="formData.percentage = formData.percentage.replace(/\D/g,'')"
                                            data-error-required="<?= get_string('validation_percentage_required', 'local_scholarship') ?>"
                                            data-error-percentage="<?= get_string('validation_percentage', 'local_scholarship') ?>"
                                            class=" py-2 pr-4 pl-12 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                            :class="{ 'border-red-500': errors.percentage }"
                                            placeholder="<?= get_string('apply_percentage_placeholder', 'local_scholarship') ?>" required>
                                        <div
                                            class="left-0 absolute inset-y-0 flex items-center pl-3 pointer-events-none">
                                            <span class="text-gray-500">%</span>
                                        </div>
                                    </div>
                                    <p x-show="errors.percentage" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.percentage"></p>
                                </div>

                                <!-- Code élève -->
                                <div>
                                    <label for="examcode" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_examcode_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="examcode" name="examcode"
                                        x-model="formData.examcode" inputmode="numeric"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        :class="{ 'border-red-500': errors.examcode }"
                                        data-error-required="<?= get_string('validation_examcode_required', 'local_scholarship') ?>"
                                        data-error-pattern="<?= get_string('validation_examcode_regex', 'local_scholarship') ?>"
                                        placeholder="<?= get_string('apply_examcode_placeholder', 'local_scholarship') ?>"
                                        maxlength="14" pattern="\d{14}"
                                        title="<?= get_string('validation_examcode_size', 'local_scholarship') ?>" required>
                                    <p x-show="errors.examcode" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.examcode"></p>
                                </div>
                            </div>
                        </div>
                        <!-- Step 4: Documents -->
                        <div x-show.transition.in="step === 4">
                            <div class="space-y-8">
                                <?php foreach ($document_types as $document): ?>
                                        <div>
                                            <label for="<?= strtolower($document['name']) ?>"
                                                class="block mb-2 font-medium text-sm">
                                                <?= $document['title'] ?>
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <div class="flex items-center mt-1">
                                                <label for="<?= strtolower($document['name']) ?>"
                                                    class="w-full cursor-pointer">
                                                    <div
                                                        class="px-4 py-6 border-2 border-gray-300 hover:border-red-400  border-dashed rounded-lg w-full text-center transition-colors">
                                                        <svg class="mx-auto w-12 h-12 text-gray-400" stroke="currentColor"
                                                            fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                            <path
                                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                        <div class="mt-2 text-gray-600  text-sm">
                                                            <span
                                                                class="font-medium text-red-500 hover:text-red-600"><?= get_string('upload_file', 'local_scholarship') ?></span>
                                                            <?= get_string('or_drag_drop', 'local_scholarship') ?>
                                                        </div>
                                                        <p class="mt-1 text-gray-500 text-xs"
                                                            x-text="formData['<?= strtolower($document['name']) ?>']">
                                                        </p>
                                                    </div>
                                                    <input id="<?= strtolower($document['name']) ?>"
                                                        name="<?= strtolower($document['name']) ?>" type="file"
                                                        accept=".pdf,image/*,.doc,.docx,.jpg,.jpeg,.png"
                                                        class="sr-only document-upload"
                                                        data-error-size="<?= get_string('validation_file_size', 'local_scholarship') ?>"
                                                        data-error-type="<?= get_string('validation_file_type', 'local_scholarship') ?>"
                                                        data-error-required="<?= get_string('validation_required', 'local_scholarship') ?>"
                                                        required
                                                        @change="formData['<?= strtolower($document['name']) ?>'] = $event.target.files[0]">
                                                </label>
                                            </div>
                                            <p class="mt-1 text-gray-500  text-xs">
                                                <?= $document['description'] ?>
                                            </p>
                                            <p x-show="errors['<?= strtolower($document['name']) ?>']"
                                                class="mt-1 text-red-500 text-sm"
                                                x-text="errors['<?= strtolower($document['name']) ?>']"></p>
                                        </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Step 5: Personal Ambitions -->
                        <div x-show.transition.in="step === 5">
                            <div class="space-y-6">
                                <!-- University Field -->
                                <div>
                                    <label for="intendedfield" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_university_field_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <select id="intendedfield" name="intendedfield"
                                        x-model="formData.intendedfield" class="form-select"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full"
                                        :class="{ 'border-red-500': errors.intendedfield }"
                                        data-error-required="<?= get_string('validation_required', 'local_scholarship') ?>" required
                                        style="width: 100%">
                                        <option value=""><?= get_string('select_option', 'local_scholarship') ?></option>
                                        <?php foreach ($intendedfields as $value => $label): ?>
                                            <option value="<?= $value ?>"><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p x-show="errors.intendedfield" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.intendedfield"></p>

                                    <!-- Champ pour "Autre" -->
                                    <div x-show="formData.intendedfield === 'other'" class="mt-3" x-transition>
                                        <label for="other_university_field" class="block mb-1 font-medium text-sm">
                                            <?= get_string('apply_other_university_field_label', 'local_scholarship') ?> <span
                                                class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="other_university_field"
                                            name="other_university_field" x-model="formData.other_university_field"
                                            class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                            :class="{ 'border-red-500': errors.other_university_field }"
                                            data-error-required="<?= get_string('validation_required', 'local_scholarship') ?>"
                                            placeholder="<?= get_string('apply_other_university_field_placeholder', 'local_scholarship') ?>">
                                        <p x-show="errors.other_university_field" class="mt-1 text-red-500 text-sm"
                                            x-text="errors.other_university_field"></p>
                                    </div>
                                </div>
                                <!-- Passion -->
                                <div>
                                    <label for="motivation" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_passion_label', 'local_scholarship') ?> <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="motivation" name="motivation" rows="3"
                                        x-model="formData.motivation"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        data-error-required="<?= get_string('validation_required', 'local_scholarship') ?>"
                                        :class="{ 'border-red-500': errors.motivation }"
                                        placeholder="<?= get_string('apply_passion_placeholder', 'local_scholarship') ?>"></textarea>
                                    <p x-show="errors.motivation" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.motivation"></p>
                                </div>
                                <!-- Career Goals -->
                                <div>
                                    <label for="careergoals" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_careergoals_label', 'local_scholarship') ?> <span
                                            class="text-red-500">*</span>
                                    </label>
                                    <textarea id="careergoals" name="careergoals" rows="3" x-model="formData.careergoals"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        data-error-required="<?= get_string('validation_required', 'local_scholarship') ?>"
                                        :class="{ 'border-red-500': errors.careergoals }"
                                        placeholder="<?= get_string('apply_careergoals_placeholder', 'local_scholarship') ?>"></textarea>
                                    <p x-show="errors.careergoals" class="mt-1 text-red-500 text-sm"
                                        x-text="errors.careergoals"></p>
                                </div>
                                <!-- Additional Information -->
                                <div>
                                    <label for="additionalinfo" class="block mb-1 font-medium text-sm">
                                        <?= get_string('apply_additional_info_label', 'local_scholarship') ?>
                                    </label>
                                    <textarea id="additionalinfo" name="additionalinfo" rows="3" x-model="formData.additionalinfo"
                                        class=" px-4 py-2 border border-gray-300 focus:border-transparent  rounded-lg focus:ring-2 focus:ring-red-500 w-full placeholder:text-slate-400"
                                        placeholder="<?= get_string('apply_additional_info_placeholder', 'local_scholarship') ?>"></textarea>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Bottom Navigation -->
                        <div class="right-0 bottom-0 left-0 fixed bg-white  shadow-md py-5"
                            x-show="step != 'complete'">
                            <div class="mx-auto px-4 max-w-3xl">
                                <div class="flex justify-between">
                                    <div class="w-1/2">
                                        <button type="button" x-show="step > 1" @click="prevStep()"
                                            class="bg-white hover:bg-gray-100 shadow-sm px-5 py-2 border rounded-lg focus:outline-none w-32 font-medium text-gray-600 text-center"><?= get_string('apply_previous', 'local_scholarship') ?></button>
                                    </div>

                                    <div class="w-1/2 text-right">
                                        <button type="button" x-show="step < 5" @click="nextStep()"
                                            class="bg-red-500 hover:bg-red-600 shadow-sm px-5 py-2 border border-transparent rounded-lg focus:outline-none w-32 font-medium text-white text-center"><?= get_string('apply_next', 'local_scholarship') ?></button>

                                        <button type="submit" x-show="step === 5" :disabled="isSubmitting"
                                            class="inline-flex justify-center items-center gap-2 bg-red-500 hover:bg-red-600 disabled:opacity-60 shadow-sm px-5 py-2 border border-transparent rounded-lg focus:outline-none w-32 font-medium text-white text-center disabled:cursor-not-allowed">
                                            <svg x-show="isSubmitting" class="w-4 h-4 text-white animate-spin"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                            </svg>
                                            <span
                                                x-text="isSubmitting ? '<?= get_string('apply_submitting', 'local_scholarship') ?>' : '<?= get_string('apply_submit', 'local_scholarship') ?>'"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
