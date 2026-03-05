<?php $title = 'User Management'; $showNav = true; require APP . 'views/layout/header.php'; ?>

<div class="max-w-4xl mx-auto mt-10 px-4 pb-10">
    <h1 class="text-3xl font-bold mb-6">User Management</h1>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php while ($user = mysqli_fetch_assoc($users)): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500"><?= $user['ID'] ?></td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        <?= htmlspecialchars($user['username']) ?>
                        <?php if ($user['username'] === $_COOKIE['ID_your_site']): ?>
                            <span class="ml-2 text-xs text-indigo-600 font-semibold">(you)</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="<?= BASE ?>/members/modify/<?= $user['ID'] ?>/"
                           class="inline-block bg-indigo-600 text-white text-xs font-semibold px-3 py-1 rounded hover:bg-indigo-700">
                            Modify
                        </a>
                        <?php if ($user['username'] !== $_COOKIE['ID_your_site']): ?>
                            <a href="<?= BASE ?>/members/delete/<?= $user['ID'] ?>/"
                               onclick="return confirm('Delete user <?= htmlspecialchars($user['username'], ENT_QUOTES) ?>?')"
                               class="inline-block bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded hover:bg-red-700">
                                Delete
                            </a>
                        <?php else: ?>
                            <span class="inline-block text-xs text-gray-400 px-3 py-1 border border-gray-200 rounded cursor-not-allowed"
                                  title="You cannot delete your own account">
                                Delete
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APP . 'views/layout/footer.php'; ?>