/*jslint node: true */
'use strict';

// import * as Vue from 'vue';
import { createApp } from 'vue/dist/vue.esm-bundler.js';

import moment from 'moment';

moment.locale('ru');

const app = createApp({});

// noinspection JSUnresolvedVariable
app.component('afisha-element', {

    'data': () => ({
        count: 0,

        ...window.afishaElement
    }),

    template: `
        <div style="display: grid;grid-template-columns: 1fr 0fr;">
        <div style="gap: 5px;display: flex;flex-direction: column;font-size: 20px;">
            <div v-if="category" style="font-weight: 500;">{{ category }}</div>
            <div style="font-size: 30px;line-height: 40px;font-weight: 500;">{{ title }}</div>
            <div v-if="datetimeStart">{{ datetimeStartFormatted }}</div>
            <div v-if="hall">{{ hall.name }}</div>
        </div>

        <div style="display: flex;flex-direction: column;align-items: end;gap: 20px;">
            <div v-if="ageRating" style="font-size: 60px;line-height: 53px;">{{ ageRating }}</div>
            <img v-if="thumbnailUrl" :src="thumbnailUrl" :alt="title" width="250">
        </div>
        </div>

        <div style="display: grid;grid-template-columns: 1fr 0fr;align-items: center;background: gray;color: white;padding: 10px;">
        <div>
            <div v-if="datetimeStart">{{ datetimeStartFormatted }}</div>
            <div v-if="hall">{{ hall.name }}</div>
        </div>

        <div>
            <button>Регистрация</button>
        </div>
        </div>

        <div style="background: #EBEBEB;padding: 10px">{{ content }}</div>
    `,

    computed: {
        datetimeStartFormatted() {
            // noinspection JSUnresolvedVariable
            const dateStart = moment(this.datetimeStart);
            console.log(dateStart);
            return dateStart.calendar();
        }
    }
});

app.mount('#afisha-app');

