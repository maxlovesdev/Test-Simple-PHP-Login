<?php $title = 'Login'; $bodyClass = 'bg-white'; $showNav = false; require APP . 'views/layout/header.php'; ?>

<div class="w-full flex flex-wrap h-screen">

    <div class="w-full md:w-1/2 flex flex-col">
        <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-24">
            <a href="<?= BASE ?>/login/" class="bg-black text-white font-bold text-xl p-4">MyApp</a>
        </div>

        <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
            <p class="text-center text-3xl">Welcome.</p>

            <?php if ($error): ?>
                <p class="text-red-500 text-center mt-4"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form class="flex flex-col pt-3 md:pt-8" action="<?= BASE ?>/login/" method="post">
                <div class="flex flex-col pt-4">
                    <label for="username" class="text-lg">Username</label>
                    <input type="text" id="username" name="username" placeholder="Your username" maxlength="40"
                        value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex flex-col pt-4">
                    <label for="pass" class="text-lg">Password</label>
                    <input type="password" id="pass" name="pass" placeholder="Password" maxlength="50"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <input type="submit" name="submit" value="Log In"
                    class="bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 mt-8 cursor-pointer">
            </form>

            <div class="text-center pt-12 pb-12">
                <p>Don't have an account? <a href="<?= BASE ?>/register/" class="underline font-semibold">Register here.</a></p>
            </div>
        </div>
    </div>

    <div class="w-1/2 shadow-2xl">
        <img class="object-cover w-full h-screen hidden md:block" src="../../img/background.png" alt="Background">
    </div>
</div>

<?php require APP . 'views/layout/footer.php'; ?>