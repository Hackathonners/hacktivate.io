<template>
    <div class="team-members">

        <div v-show="isFull" class="alert alert-success alert-dismissible fade show" role="alert">
            Congratulations, your team is complete!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div v-show="error" class="alert alert-danger fade show" role="alert">
            {{ error }}
            <button @click="error = null" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <searchable-input
            http-endpoint="/users"
            :disabled="isFull"
            :on-select="onSelectResult"
            :selectedIds="selectedIds"
            :allow-duplicate-selection="false"
        >
        </searchable-input>

        <ul class="list-group">
            <li
                :class="['media d-flex align-items-center list-group-item', { disabled: isLoading(index) }]"
                v-for="(member, index) in selectedMembers"
                :key="member.id"
            >
                <img class="mr-3 rounded" width="44" :src="member.avatar" :alt="`${member.github}`">
                <div class="media-body">
                    <h6 class="mt-0 mb-0"><strong>{{ member.github }}</strong> <small class="mb-0">{{ member.name }}</small></h6>
                </div>

                <span v-if="isOwner(member.id)" class="badge badge-light">Owner</span>
                <button v-else v-show="!isLoading(index)" type="button" class="close" aria-label="Close" @click.prevent="removeSelectedMember(index)">
                    <i class="far fa-times"></i>
                </button>
                <i v-show="isLoading(index)" class="searchable-input-icon far fa-spin fa-circle-notch"></i>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            currentMembers: {
                type: Array,
                default: () => [],
            },
            ownerId: {
                type: Number,
                required: true,
            },
            maximumMembers: {
                type: Number,
                default: 4,
            },
            teamId: {
                type: Number,
                required: true,
            }
        },
        data() {
            return {
                selectedMembers: [],
                loadingIndexes: [],
                error: null,
            };
        },
        mounted() {
            this.selectedMembers = this.currentMembers;
        },
        computed: {
            isFull() {
                return this.selectedMembers.length === this.maximumMembers;
            },
            selectedIds() {
                return this.selectedMembers.map(member => member.id);
            },
        },
        methods: {
            onSelectResult(result) {
                this.addTeamMember(result);
            },
            isOwner(id) {
                return this.ownerId === id;
            },
            isLoading(index) {
                return this.loadingIndexes.find((i) => i === index) != undefined;
            },
            removeSelectedMember(index) {
                const user = this.selectedMembers[index];
                const loadingIndex = this.loadingIndexes.push(index) - 1;
                axios.delete(`/teams/${this.teamId}/members/${user.github}`)
                    .then((response) => {
                        this.selectedMembers.splice(index, 1);
                    })
                    .catch((error) => {
                        this.error = error.response.data.message;
                    })
                    .then(() => this.loadingIndexes.splice(loadingIndex, 1));
            },
            addTeamMember(user) {
                const index = this.selectedMembers.push(user) - 1;
                const loadingIndex = this.loadingIndexes.push(index) - 1;
                axios.post(`/teams/${this.teamId}/members`, { github: user.github })
                    .catch((error) => {
                        this.selectedMembers.splice(index, 1)
                        this.error = error.response.data.message;
                    })
                    .then(() => this.loadingIndexes.splice(loadingIndex, 1));
            },
        },
        watch: {
            // searchQuery() {
            //     this.searchResults = [];
            //     this.getRemoteResults();
            // },
        }
    }
</script>
