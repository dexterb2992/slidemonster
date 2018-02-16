<template>
    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li v-for="tab in tabs" :class="{'nav-item active' : tab.isActive}">
                <a :href="tab.href" @click="selectTab(tab)" class="nav-item nav-link btn-round btn-simple">{{ tab.name }}</a>
            </li>
        </ul>

        <div class="tab-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return { tabs: [] };
        },
        created() {
            this.tabs = this.$children;
        },

        methods: {
            selectTab(selectedTab) {
                this.tabs.forEach(tab => {
                    tab.isActive = (tab.name == selectedTab.name);
                });
            }
        }
    }
</script>