<?php

/**
 * Configurable filter bar.
 * $cfg = [
 *   'searchName' => 'q',               // GET key for search
 *   'searchPH'   => 'Search …',        // placeholder
 *   'selects'    => [                  // array of selects
 *       ['id' => 'status', 'label' => 'Status', 'options' => [
 *           ''=>'All', 'new'=>'New', 'review'=>'Review',
 *           'progress'=>'In Progress', 'resolved'=>'Resolved'
 *       ]],
 *       // add more selects here …
 *   ],
 * ];
 */

$cfg      = $cfg ?? [];
$search   = $cfg['searchName'] ?? 'q';
$ph       = $cfg['searchPH']   ?? 'Search …';
$selects  = $cfg['selects']    ?? [];
?>
<section class="filters-component">
    <div class="filters-container">
        <!-- search -->
        <div class="search-section">
            <div class="search-wrapper">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="search"
                    name="<?= $search ?>"
                    value="<?= htmlspecialchars($_GET[$search] ?? '') ?>"
                    class="search-input rounded-sm"
                    placeholder="<?= $ph ?>">
            </div>
        </div>

        <div class="filter-section">
            <?php foreach ($selects as $sel): ?>
                <div class="filter-group">
                    <label class="filter-label" for="<?= $sel['id'] ?>"><?= $sel['label'] ?></label>
                    <select id="<?= $sel['id'] ?>"
                        name="<?= $sel['id'] ?>"
                        class="filter-select rounded-sm">
                        <?php foreach ($sel['options'] as $val => $text): ?>
                            <option value="<?= $val ?>"
                                <?= ($_GET[$sel['id']] ?? '') === $val ? 'selected' : '' ?>>
                                <?= $text ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    .filters-component {
        width: 100%;
        background: var(--color-surface);
        padding: 0.2rem 0;
        box-sizing: border-box;
    }

    .filters-component .filters-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 2rem;
        box-sizing: border-box;
    }

    .filters-component .search-section {
        flex: 1;
        min-width: 300px;
    }

    .filters-component .search-wrapper {
        position: relative;
        max-width: 400px;
    }

    .filters-component .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--color-text-muted);
    }

    .filters-component .search-input {
        width: 100%;
        padding: .875rem 1rem .875rem 3rem;
        border: 2px solid var(--color-border);
        font-size: .95rem;
        background: var(--color-background);
        transition: .3s;
        box-sizing: border-box;
    }

    .filters-component .search-input:focus {
        outline: none;
        border-color: var(--color-secondary);
        box-shadow: 0 0 0 3px rgba(74, 222, 128, .1);
    }

    /* filter selects */
    .filters-component .filter-section {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .filters-component .filter-group {
        display: flex;
        flex-direction: column;
        gap: .5rem;
        min-width: 140px;
    }

    .filters-component .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--color-text);
        text-transform: uppercase;
        letter-spacing: .05em;
    }

    .filters-component .filter-select {
        width: 100%;
        padding: .75rem 1rem;
        font-size: .9rem;
        border: 2px solid var(--color-border);
        background: var(--color-background);
        transition: border-color .2s, box-shadow .2s;
        cursor: pointer;
    }

    .filters-component .filter-select:focus {
        outline: none;
        border-color: var(--color-secondary);
        box-shadow: 0 0 0 3px rgba(74, 222, 128, .1);
    }

    @media (min-width: 1024px) and (max-width: 1199px) {
        .filters-component .filters-container {
            max-width: none;
            width: 100%;
        }

        .filters-component .search-section {
            flex: 1 1 50%;
            min-width: 280px;
        }

        .filters-component .search-wrapper {
            max-width: none;
            width: 100%;
        }

        .filters-component .filter-section {
            flex: 1 1 50%;
            justify-content: flex-end;
            gap: 1.25rem;
        }

        .filters-component .filter-group {
            min-width: 120px;
            flex: 1;
        }
    }

    @media (min-width: 1024px) and (max-width: 1160px) {
        .filters-component .filters-container {
            gap: 1.5rem;
        }

        .filters-component .search-section {
            flex: 1 1 60%;
            min-width: 250px;
        }

        .filters-component .filter-section {
            flex: 1 1 40%;
            gap: 1rem;
        }

        .filters-component .filter-group {
            min-width: 100px;
        }

        .filters-component .filter-select {
            padding: .65rem .85rem;
            font-size: .85rem;
        }
    }


    @media (max-width:1023px) and (min-width:768px) {
        .filters-component {
            padding: 1rem 1.5rem;
        }

        .filters-component .filters-container {
            gap: 1.5rem;
            max-width: none;
            width: 100%;
        }

        .filters-component .search-section {
            flex: 1 1 100%;
            min-width: auto;
            margin-bottom: 0.5rem;
        }

        .filters-component .search-wrapper {
            max-width: 100%;
        }

        .filters-component .filter-section {
            flex: 1 1 100%;
            justify-content: space-between;
            gap: 1rem;
        }

        .filters-component .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filters-component .filter-select {
            width: 100%;
        }
    }

    @media (max-width:767px) {
        .filters-component {
            padding: 0.75rem 1rem;
        }

        .filters-component .filters-container {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
            max-width: none;
            width: 100%;
        }

        .filters-component .search-section {
            min-width: auto;
        }

        .filters-component .search-wrapper {
            max-width: 100%;
        }

        .filters-component .filter-section {
            gap: 0.75rem;
        }

        .filters-component .filter-group {
            flex: 1;
            min-width: 100px;
        }

        .filters-component .filter-select {
            min-width: auto;
            width: 100%;
            padding: 0.65rem 0.75rem;
            font-size: 0.85rem;
        }
    }

    @media (max-width:479px) {
        .filters-component {
            padding: 0.5rem 0.75rem;
        }

        .filters-component .filters-container {
            gap: 0.75rem;
        }

        .filters-component .filter-section {
            flex-direction: column;
            gap: 0.5rem;
        }

        .filters-component .search-input {
            padding: 0.75rem 0.75rem 0.75rem 2.5rem;
            font-size: 0.82rem;
        }

        .filters-component .search-icon {
            left: 0.75rem;
            width: 18px;
            height: 18px;
        }

        .filters-component .filter-label {
            font-size: 0.7rem;
        }

        .filters-component .filter-select {
            font-size: 0.82rem;
        }
    }
</style>