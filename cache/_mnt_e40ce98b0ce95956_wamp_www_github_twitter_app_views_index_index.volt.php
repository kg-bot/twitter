<?php if ($posts) { ?>
    <?php foreach ($posts as $post) { ?>
        <div class="panel panel-default" data-id=<?= $post->getId() ?>>
            <div class="panel-body">
                <?= $post->getPost() ?>
                <?php if ($post->getEmail() == $this->session->get('email') || $this->session->get('role') == 'admin') { ?>
                    <div class="text-center">
                        <a class="btn btn-danger" href="#" role="button">Delete</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>