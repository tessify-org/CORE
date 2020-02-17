<template>
    <div class="date-picker">
        
        <!-- Input -->
        <v-text-field :id="name" type="text" class="form-control" :label="label" :value="mutableValue" :hint="hint" autocomplete="off" :hide-details="!hasHint" persistent-hint placeholder="00/00/0000"></v-text-field>
        
        <!-- Hidden -->
        <input type="hidden" :name="name" v-model="mutableValue">

    </div>
</template>

<script>
    export default {
        props: [
            "name",
            "label",
            "value",
            "hint",
            "options"
        ],
        data(){
            return {
                tag: "[datepicker-input]",
                mutableValue: this.value,
                dp: null,
            }
        },
        computed: {
            hasHint() {
                return this.hint !== undefined && this.hint !== null && this.hint !== "";
            }
        },
        watch: {
            mutableValue: function() {
                this.$emit("input", this.mutableValue);
            },
            value: function() {
                if (this.value === null) {
                    this.dp.clear();
                }
            }
        },
        methods: {
            initialize(){
                $.fn.datepicker.language['nl'] = {
                    days: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
                    daysShort: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
                    daysMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
                    months: ['Januari','Februari','Maart','April','Mei','Juni', 'Juli','Augustus','September','Oktober','November','December'],
                    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
                    today: 'Vandaag',
                    clear: 'Reset',
                    dateFormat: 'dd/mm/yyyy',
                    timeFormat: 'hh:ii aa',
                    firstDay: 0
                };
                $(document).ready(function(){
                    this.dp = $("#"+this.name).datepicker({
                        language: "nl",
                        dateFormat: "dd/mm/yyyy",
                        autoClose: true,
                        onSelect: function(formattedDate, date, inst) {
                            this.mutableValue = formattedDate;
                        }.bind(this)
                    }).data('datepicker');
                    if (this.value != "" && this.value != null) {
                        let initialDate = new Date(this.value);
                        this.dp.selectDate(initialDate);
                    }
                }.bind(this));
            },
        },
        mounted(){
            this.initialize();
        }
    }
</script>

<style lang="scss">
    .date-picker {
        width: 100%;
        .date-picker__label {
            font-size: 12px;
            color: hsl(0, 0%, 35%);
        }
    }
</style>
