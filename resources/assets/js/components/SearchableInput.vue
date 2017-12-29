<template>
    <div class="searchable-form-input mb-2"
        v-click-outside="hideResults"
        @keydown.up.prevent="goUp"
        @keydown.down.prevent="goDown"
    >
        <i v-show="loading" class="searchable-input-icon far fa-spin fa-circle-notch"></i>
        <input
            type="text"
            autocomplete="off"
            autofocus
            :placeholder="placeholder"
            :disabled="disabled"
            v-model="query"
            :class="['form-control searchable-input', cssClass]"
            @focus="inputFocus = true"
            @blur="inputFocus = false"
            @keydown.enter.prevent
        >

        <div class="searchable-results list-group small" :ref="'searchResults'" v-show="visibleResults">
            <a
                href="#"
                tabindex="-1"
                v-for="(result, index) in searchResults"
                :key="result[id]"
                :ref="`result${index}`"
                :class="[
                    'list-group-item list-group-item-action py-2 px-3 search-result',
                    { active: index === currentSelectionIndex, 'disabled': isSelectedResult(result[id]) }
                ]"
                @focus="hoverResult(index)"
                @blur="hideResults()"
                @click.prevent.prevent="selectResult(index)">

                <div class="media d-flex align-items-center search-result-content">
                    <img class="mr-3 rounded" width="24" :src="result.avatar" :alt="`@${result.github} avatar`">
                    <div class="media-body">
                        <strong>{{ result.github }}</strong> {{ result.name }}
                    </div>
                    <span v-if="isSelectedResult(result[id])" class="ml-auto"><i class="far fa-check"></i></span>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    import _debounce from 'lodash.debounce';

    export default {
        props: {
            cssClass: String,
            placeholder: {
                type: String,
                default: 'Search...'
            },
            onSelect: {
                type: Function,
                required: true,
            },
            selectedIds: {
                type: Array,
                default: () => [],
            },
            httpEndpoint: {
                type: String,
                required: true,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            errors: {
                type: Array,
                default: () => [],
            },
            id: {
                type: String,
                default: 'id',
            },
            allowDuplicateSelection: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                query: '',
                searchResults: [],
                currentSelectionIndex: -1,
                inputFocus: false,
                resultsHover: false,
                loading: false,
            };
        },
        computed: {
            lastIndex() {
                return this.searchResults.length - 1;
            },
            visibleResults() {
                return (this.inputFocus || this.resultsHover) && this.searchResults.length > 0;
            },
        },
        methods: {
            isSelectedResult(selectedId) {
                return this.selectedIds.find((id) => id === selectedId) != undefined;
            },
            hideResults() {
                this.inputFocus = this.resultsHover = false;
                this.currentSelectionIndex = -1;
            },
            hoverResult(index) {
                this.currentSelectionIndex = index;
                this.resultsHover = true;

                this.$nextTick(() => {
                    this.$refs[`result${index}`][0].focus()
                });
            },
            goDown() {
                if (this.visibleResults && this.currentSelectionIndex < this.lastIndex) {
                    this.hoverResult(this.currentSelectionIndex + 1);
                }
            },
            goUp() {
                if (this.visibleResults && this.currentSelectionIndex > 0) {
                    this.hoverResult(this.currentSelectionIndex - 1);
                }
            },
            selectResult(index) {
                const selectedResult = this.searchResults[this.currentSelectionIndex];
                if (this.isSelectedResult(selectedResult.id) && !this.allowDuplicateSelection) {
                    return;
                }

                this.hoverResult(index);
                this.onSelect(selectedResult);

                if (this.isFull) {
                    this.query = '';
                    this.hideResults();
                }
            },
            getRemoteResults: _debounce(function () {
                if (this.query === '') {
                    return;
                }

                this.loading = true;
                axios.get(this.httpEndpoint, { params: { query: this.query } })
                    .then((response) => {
                        this.searchResults = response.data.data;
                    })
                    .catch((error) => {
                        // TODO: handle request error.
                    })
                    .then(() => this.loading = false);
            }, 500),
        },
        watch: {
            visibleResults(val) {
                if (val) {
                    this.$nextTick(() => {
                        this.$refs.searchResults.scrollTop = 0;
                    });
                }
            },
            query() {
                this.searchResults = [];
                this.getRemoteResults();
            },
            disabled() {
                this.query = '';
            }
        }
    }
</script>
