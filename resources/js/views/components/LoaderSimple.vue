<template>
     <div class="page-loader" v-if="processing">
        <div class="loader">
            <span class="dot dot_1"></span>
            <span class="dot dot_2"></span>
            <span class="dot dot_3"></span>
            <span class="dot dot_4"></span>
            <span class="text mt-4 pt-3" v-html="text"></span>
        </div>
    </div>
</template>

<script>
    import { loaderState } from '@src/store/loaderState.js';

    export default {
        data() {
            return {
                processing: false,
                text: 'Processing...',
            }
        },
        created() {
            // Watch the loaderState from loaderState data store
            loaderState().$subscribe((mutation, state) => {
                this.processing = state.processing;
            });
        },
    }
</script>

<style>
    .page-loader{ 
        background: #1e1e1e85 none repeat scroll 0 0;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 9998;
    }
    .loader {
        height: 8px;
        margin: 0 auto;
        position: relative;
        text-align: center;
        top: 50%;
        width: 44px;
    }
    .dot {
        background: #e7e7e7 none repeat scroll 0 0;
        border-radius: 50%;
        display: inline-block;
        width: 12px;
        height: 12px;
        position: absolute;
    }
    .dot_1 {
        animation: 1.5s linear 0s normal none infinite running animateDot1;
        background: #f26f29 none repeat scroll 0 0;
        left: 12px;
    }
    .dot_2 {
        animation: 1.5s linear 0.5s normal none infinite running animateDot2;
        left: 24px;
    }
    .dot_3 {
        animation: 1.5s linear 0s normal none infinite running animateDot3;
        left: 12px;
    }
    .dot_4 {
        animation: 1.5s linear 0.5s normal none infinite running animateDot4;
        left: 24px;
    }
    span.text {
        display: inline-block;
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-50%);
        color: #e7e7e7;
        font-size: 16pt;
    }
    @keyframes animateDot1 {
        0% {
            transform: rotate(0deg) translateX(-12px);
        }
        25% {
            transform: rotate(180deg) translateX(-12px);
        }
        75% {
            transform: rotate(180deg) translateX(-12px);
        }
        100% {
            transform: rotate(360deg) translateX(-12px);
        }
    }
    @keyframes animateDot2 {
        0% {
            transform: rotate(0deg) translateX(-12px);
        }
        25% {
            transform: rotate(-180deg) translateX(-12px);
        }
        75% {
            transform: rotate(-180deg) translateX(-12px);
        }
        100% {
            transform: rotate(-360deg) translateX(-12px);
        }
    }
    @keyframes animateDot3 {
        0% {
            transform: rotate(0deg) translateX(12px);
        }
        25% {
            transform: rotate(180deg) translateX(12px);
        }
        75% {
            transform: rotate(180deg) translateX(12px);
        }
        100% {
            transform: rotate(360deg) translateX(12px);
        }
    }
    @keyframes animateDot4 {
        0% {
            transform: rotate(0deg) translateX(12px);
        }
        25% {
            transform: rotate(-180deg) translateX(12px);
        }
        75% {
            transform: rotate(-180deg) translateX(12px);
        }
        100% {
            transform: rotate(-360deg) translateX(12px);
        }
    }
</style>