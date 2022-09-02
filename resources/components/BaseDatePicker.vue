<template>
  <div class="datepicker">
    <input
      type="text"
      @focus="show()"
      v-model="formData"
      :placeholder="props.placeholder"
    />
    <div v-if="visible" :class="['calendar', { show: visible }]">
      <div class="calendar__header">
        <div class="calendar__year">{{ formattedYear }}</div>
        <div class="calendar__date">{{ formattedDate }}</div>
      </div>
      <div class="calendar__body">
        <div class="calender_top_select">
          <button class="calendar__month__prev" @click="prev">
            <b>></b>
          </button>
          <select
            v-model="monthValue"
            class="date_select"
            size="mini"
            name=""
            id=""
          >
            <option
              v-for="(month, index) in getMonthsList"
              :value="index"
              :key="month"
            >
              {{ month }}
            </option>
          </select>
          <select
            v-model="yearValue"
            class="date_select"
            size="mini"
            name=""
            id=""
          >
            <option
              style="text-align-last: center"
              v-for="i in numberOfYears"
              :key="i"
              :value="startingYear + (i - 1)"
              :label="
                formatEnglish
                  ? startingYear + (i - 1)
                  : getNepaliYears(startingYear + (i - 1))
              "
            ></option>
          </select>
          <button class="calendar__month__next" @click="next">
            <b>></b>
          </button>
        </div>

        <!-- WEEKS -->
        <div class="calendar__weeks" style="padding: 3px">
          <div
            v-for="day in weekdays"
            :key="day"
            style="font-weight: bold"
            class="calendar__weekday"
          >
            {{ day }}
          </div>
        </div>
      </div>
      <!-- days of month -->
      <div class="calendar__days">
        <div
          class="calendar__day_spacer"
          :style="{ gridColumn: `span ${startWeek}` }"
        ></div>
        <div
          :class="[
            'calendar__day',
            { selected: active(day) },
            { today: checkToday(day) },
          ]"
          v-for="(day, d) in days"
          :key="d"
          @click="selectDay(day)"
        >
          {{ formatNepali ? convertToNepali(day).substr(8, 10) : day.day }}
        </div>
      </div>
      <div class="calendar__footer">

        <button v-if="props.calenderType === 'English'" @click="yesterday">{{ formattedYesterdayText }}</button>
        <button @click="today">{{ formattedTodayText }}</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref } from "@vue/reactivity";
import useDate from "../components_js/useDate";

const formData = ref("");

function selectDay(dayData) {
  formData.value = selectDate(dayData);
}
function yesterday() {
  formData.value = getYesterday();
}

function today() {
  formData.value = getToday();
}

const props = defineProps({
  calenderType: { type: String, default: "Nepali" },
  format: {
    type: String,
    default(rawProps) {
      if (rawProps.calenderType === "English") {
        return "YYYY-MM-DD";
      }
      return "yyyy-mm-dd";
    },
  },
  yearSelect: { type: Boolean, default: true },
  monthSelect: { type: Boolean, default: true },
  classValue: { type: String, default: "" },
  placeholder: { type: String, default: "" },
  modelValue: { type: String, default: "" },
});
const {
  // states
  date,
  formatNepali,
  formatEnglish,
  endDay,
  formattedYear,
  defaultDateFormat,
  defaultEnglishDateFormat,
  getToday,
  selectDate,
  formattedDate,
  formattedTodayText,
  formattedYearOrMonth,
  getMonthsList,
  year,
  days,
  weekdays,
  yearValue,
  monthValue,
  startingYear,
  visible,
  //    methods
  active,
  checkToday,
  show,
  hide,
  // feature next-prev
  prev,
  next,
  //    others
  NepaliDate,
  // feature years
  numberOfYears,
  getNepaliYears,
  convertToNepali,
  // feature week
  startMonthValue,
  startWeek,
  getYesterday,
  formattedYesterdayText,
} = useDate(props);
</script>

<style scoped>
* {
  margin: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}
.datepicker {
  position: relative;
}
.datepicker button {
  outline: none;
  border: 0;
  /* background: transparent; */
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}
.calendar {
  border: 1px solid black;
  z-index: 9;
  position: absolute;
  width: 350px;
  top: 100%;
  box-shadow: 0px 14px 45px rgba(0, 0, 0, 0.25),
    0px 10px 18px rgba(0, 0, 0, 0.22);
  background-color: rgb(247, 248, 248);
  /* visibility: hidden; */
  /* opacity: 0;    */
  /* transform: translateY(-50%) translateX(50%); */
  /* transition: all 0.3s linear; */
}
/* .calendar.show {
  visibility: visible;
  opacity: 1;
  /* transform: translateY(0px); */
/* } */
.date_select {
  border-radius: 5px;
  padding: 5px 5px;
  margin: 5px 5px;
}
.calendar__body {
  display: flex;
  flex-direction: column;
}
.calender_top_select {
  display: flex;
  justify-content: space-between;
}
.calendar__header {
  padding: 15px 10px;
  /* border-radius: 10px; */
  background: #5495c5;
  color: #fff;
}
.calendar__year {
  opacity: 0.6;
  font-size: 1rem;
  line-height: 1.2rem;
}
.calendar__date {
  font-size: 1.2rem;
  line-height: 1.5rem;
}
.calendar__month {
  padding: 5px 3px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.calendar__month select {
  height: 28px;
  width: 100px;
  border-radius: 5px;
  border-color: #7ca3f1;
  text-align-last: center;
}
.calendar__month button {
  width: 25px;
  margin-right: 4px;
  height: 28px;
  margin-left: 4px;
  border-radius: 5px;
  color: white;
  text-align: center;
  background: #247ac4;
}
.calendar__month button:hover {
  background: rebeccapurple;
}
.calendar__month__prev {
  transform: rotate(180deg);
  background: #1c94b8;
  color: white;
  border-radius: 5px;
  padding: 5px 10px;
  margin: 5px 4px;
}
.calendar__month__prev:hover,
.calendar__month__next:hover {
  background: rgba(255, 0, 0, 0.718);
}

.calendar__month__next {
  border-radius: 5px;
  background: #1c94b8;
  color: white;
  padding: 5px 10px;
  margin: 5px 4px;
}
.calendar__weeks,
.calendar__days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}
.calendar__days {
  gap: 5px;
  row-gap: 1.5ch;
  justify-items: center;
  margin-bottom: 2%;
}
.calendar__day,
.calendar__weekday {
  text-align: center;
  font-size: 16px;
}
.calendar__weekday {
  opacity: 0.8;
  font-weight: 300;
}
.calendar__day {
  width: 35px;
  height: 35px;
  font-size: 20px;
  line-height: 32px;
  font-weight: 300;
  color: #1c94b8;
  font-weight: bold;
  cursor: pointer;
  border-radius: 5px;
  background: #dfeffc;
  /* transition: all 0.3s ease-in-out; */
}
.calendar__day.selected {
  background: #5495c5;
  color: #fff;
}
.calendar__day.today {
  background: #f77777;
  color: #fff;
}
.calendar__day:hover {
  background: red;
  color: #fff;
  opacity: 0.8;
}
.calendar__footer {
  display: flex;
  justify-content: end;
  border-top: 1px solid;
  text-align: right;
}
.calendar__footer button {
  padding: 8px 10px;
  text-transform: uppercase;
  font-weight: bold;
  background: #5495c5;
  color: white;
  opacity: 0.9;
  margin: 5px;
  border-radius: 5px;
}
.calendar__footer button:hover {
  opacity: 1;
}
</style>
