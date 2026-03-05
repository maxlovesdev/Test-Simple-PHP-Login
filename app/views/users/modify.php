<?php $title = 'Modify User'; $showNav = true; require APP . 'views/layout/header.php'; ?>

<div class="max-w-md mx-auto mt-10 px-4 pb-10">
    <div class="bg-white shadow rounded p-8">
        <h1 class="text-2xl font-bold mb-2">Modify User</h1>
        <p class="text-gray-500 mb-6">
            Changing password for <strong><?= htmlspecialchars($targetUser['username']) ?></strong>
            <?php if ($targetUser['username'] === $_COOKIE['ID_your_site']): ?>
                <span class="text-indigo-600">(you)</span>
            <?php endif; ?>
        </p>

        <?php if ($success): ?>
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                Password updated successfully.
            </div>
            <a href="<?= BASE ?>/members/" class="block text-center bg-black text-white font-bold py-2 hover:bg-gray-700">
                Back to Users
            </a>
        <?php else: ?>
            <?php if ($error): ?>
                <p class="text-red-500 mb-4"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form action="<?= BASE ?>/members/modify/<?= $targetUser['ID'] ?>/" method="post" class="flex flex-col space-y-4">
                <div class="flex flex-col">
                    <label for="new_pass" class="text-lg mb-1">New Password</label>
                    <input type="password" id="new_pass" name="new_pass" placeholder="New password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex flex-col">
                    <label for="confirm_pass" class="text-lg mb-1">Confirm Password</label>
                    <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm new password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex space-x-3 pt-2">
                    <input type="submit" name="submit" value="Save Changes"
                        class="flex-1 bg-black text-white font-bold text-lg hover:bg-gray-700 p-2 cursor-pointer">
                    <a href="<?= BASE ?>/members/"
                        class="flex-1 text-center border border-gray-300 text-gray-700 font-bold text-lg hover:bg-gray-100 p-2">
                        Cancel
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require APP . 'views/layout/footer.php'; ?>