<?php $uri = service('uri')->getSegments(); ?>

<!-- Object Rating and Review -->
<div class="card">
    <div class="card-header text-center">
        <h4 class="card-title">Rating and Review</h4>
        <?php if (in_groups('user')): ?>
            <form class="form form-vertical" action="<?= base_url('web/review'); ?>" method="post" onsubmit="checkStar(event);">
                <div class="form-body">
                    <div class="star-containter mb-3">
                        <i class="fa-solid fa-star fs-4" id="star-1" onclick="setStar('star-1');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-2" onclick="setStar('star-2');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-3" onclick="setStar('star-3');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-4" onclick="setStar('star-4');"></i>
                        <i class="fa-solid fa-star fs-4" id="star-5" onclick="setStar('star-5');"></i>
                        <input type="hidden" id="star-rating" value="0" name="rating">
                        <input type="hidden" value="<?= $uri[2]; ?>" name="object_id">
                    </div>
                    <div class="col-12 mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here"
                                      id="floatingTextarea" style="height: 150px;" name="comment"></textarea>
                            <label for="floatingTextarea">Leave a comment here</label>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end mb-3">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <?php if (!url_is("*detail*")): ?>
                <p class="card-text">Please login as User to give rating and review</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="reviews">
                <tbody>
                <?php foreach ($data['reviews'] as $review):  ?>
                    <tr>
                        <td>
                            <p class="mb-0">
                                <?php for ($i = 0; $i < (int)esc($review['rating']); $i++) { ?>
                                    <span class="material-symbols-outlined rating-color">star</span>
                                <?php } ?>
                                <?php for ($i = 0; $i < (5 - (int)esc($review['rating'])); $i++) { ?>
                                    <span class="material-symbols-outlined">star</span>
                                <?php } ?>
                            </p>
                            <p class="mb-0"><?= "{$review['first_name']} {$review['last_name']}"; ?></p>
                            <p class="fw-light"><?= date('Y-m-d', strtotime(esc($review['created_at']))); ?></p>
                            <?php if (!empty($review['comment'])) { ?>
                                <p class="fw-bold"><?= esc($review['comment']); ?></p>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>