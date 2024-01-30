<template>
    <ul v-if="prev || next" class="pagination float-right mt-3">
        <li
            v-for="(link, index) in links"
            :key="index"
            :class="{ active: link.active }"
        >
            <a
                v-if="isLabeled(link.label) === 'Previous' && prev"
                @click="list(--currentPage)"
                >{{ isLabeled(link.label) }}</a
            >
            <a
                v-else-if="isLabeled(link.label) === 'Next' && next"
                @click="list(++currentPage)"
                >{{ isLabeled(link.label) }}</a
            >
            <a
                v-else-if="
                    isLabeled(link.label) !== 'Previous' &&
                    isLabeled(link.label) !== 'Next'
                "
                @click="list(link.label)"
                >{{ link.label }}</a
            >
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        prev: {
            type: undefined,
            required: true,
        },
        next: {
            type: undefined,
            required: true,
        },
        links: {
            type: Array,
            required: true,
        },
        currentPage: {
            type: Number,
            required: true,
        },
        list: {
            type: Function,
            required: true,
        },
    },
    methods: {
        isLabeled(label) {
            if (label.includes("Previous")) return "Previous";
            else if (label.includes("Next")) return "Next";
            else if (!label.includes("Previous") && !label.includes("Next"))
                return label;
        },
    },
};
</script>

<style>
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
    cursor: pointer;
}

.pagination li a {
    display: block;
    padding: 5px 10px;
    text-decoration: none;
    color: #000;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 3px;
}

.pagination li.active a {
    background-color: #3a9aa6;
    color: #fff;
}

.pagination li:hover a {
    background-color: #ddd;
}
</style>
