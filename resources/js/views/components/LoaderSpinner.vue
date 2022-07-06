<template>
    <div class="page-loader" v-if="processing">
        <div class="d-grid gap-0 align-items-center position-absolute top-50 start-50 translate-middle">
            <div class="loader" :class="type">
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4 w-100">
                <h4 class="text-white">{{ text }}</h4>
            </div>
        </div>
    </div>
</template>

<script>
    import { loaderState } from '@src/store/loaderState.js';

    export default {
        data() {
            return {
                type: 'loader1',
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
        position: fixed;
        background: #1e1e1e85 none repeat scroll 0 0;
        height: 100%;
        left: 0;
        top: 0;
        width: 100%;
        z-index: 9998;
    }
    @-webkit-keyframes rotate {
        0% {
            transform: rotate(0deg);
        }
        50% {
            transform: rotate(180deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    @keyframes rotate {
        0% {
            transform: rotate(0deg);
        }
        50% {
            transform: rotate(180deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
    @-webkit-keyframes rotate2 {
        0% {
            transform: rotate(0deg);
            border-top-color: #3498db;
        }
        50% {
            transform: rotate(180deg);
            border-top-color: #e74c3c;
        }
        100% {
            transform: rotate(360deg);
            border-top-color: #f9c922;
        }
    }
    @keyframes rotate2 {
        0% {
            transform: rotate(0deg);
            border-top-color: #3498db;
        }
        50% {
            transform: rotate(180deg);
            border-top-color: #e74c3c;
        }
        100% {
            transform: rotate(360deg);
            border-top-color: #f9c922;
        }
    }
    .loader {
        /* position: relative; */
        margin: auto;
        width: 130px;
        height: 130px;
        display: block;
        overflow: hidden;
    }
    .loader div {
        height: 100%;
    }

    /* loader 1 */
    .loader1, .loader1 div {
        border-radius: 50%;
        padding: 6px;
        border: 3px solid transparent;
        -webkit-animation: rotate linear 3.5s infinite;
                animation: rotate linear 3.5s infinite;
        border-top-color: #e74c3c;
        border-bottom-color: #f9c922;
    }

    /*loader 2  */
    .loader2, .loader2 div {
        border-radius: 50%;
        padding: 6px;
        border: 3px solid transparent;
        -webkit-animation: rotate linear 3.5s infinite;
                animation: rotate linear 3.5s infinite;
        border-top-color: #3498db;
        border-left-color: #e74c3c;
        border-right-color: #f9c922;
    }

    /*loader 3  */
    .loader3, .loader3 div {
    border-radius: 50%;
    padding: 6px;
    border: 3px solid transparent;
    -webkit-animation: rotate linear 3.5s infinite;
            animation: rotate linear 3.5s infinite;
    border-top-color: #e74c3c;;
    border-left-color: #f9c922;
    -webkit-animation-timing-function: cubic-bezier(0.55, 0.38, 0.21, 0.88);
            animation-timing-function: cubic-bezier(0.55, 0.38, 0.21, 0.88);
    -webkit-animation-duration: 3s;
            animation-duration: 3s;
    }

    /* loader 4 */
    .loader4, .loader4 div {
        border-radius: 50%;
        padding: 6px;
        border: 3px solid transparent;
        -webkit-animation: rotate linear 3.5s infinite;
                animation: rotate linear 3.5s infinite;
        border-radius: 50%;
        padding: 2px;
        -webkit-animation: rotate2 4s infinite linear;
                animation: rotate2 4s infinite linear;
    }

    div:hover {
        -webkit-animation-play-state: paused;
                animation-play-state: paused;
    }

    .loader, .loader * {
        will-change: transform;
    }
</style>