@extends('layouts.app-client', ['title' => __('Chat')])
@section('title')
    {{ __('Chat') }}
    <x-button-links />
@endsection
@section('css')
    <link href="{{ asset('backend/Assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link rel='stylesheet' type='text/css' href="{{ asset('backend/Assets/File_manager/css/file_manager.css') }}">
    <style>
        :root {
            --sidebar-width: 380px;
            --chat-bg: #07070726;
            --outgoing-bg: #dcf8c6;
            --incoming-bg: #ffffff;
            --primary-color: #128c7e;
            --text-color: #a7b3bb;
            --light-text: #667781;
            --border-color: #bbbbbb;
            --chat-area-bg: #172c21b5;
            --conversation-header-bg: rgb(255, 255, 255);
        }

        /* Light mode */
        @media (prefers-color-scheme: light) {
            :root {
                --chat-area-bg: #172c21b5;
                --conversation-header-bg: rgb(43, 244, 205);
                --incoming-bg: #ffffff;
                --outgoing-bg: #dcf8c6;
            }
        }

        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            :root {
                --chat-area-bg: #172c21b5;
                --conversation-header-bg: rgb(255, 255, 255);
                --incoming-bg: #222222;
                --outgoing-bg: #056162;
            --border-color: #bbbbbb;
            }
        }


        .chat-bubble {
            max-width: 380px;
            /* Desktop */
        }

        @media (max-width: 768px) {
            .chat-bubble {
                max-width: 320px;
                /* Mobile */
            }
        }

        .card-header:first-child {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
        }

        .card-footer:last-child {
            border-radius: 0 !important;
        }

        .chat-container {
            display: flex;
            height: calc(100vh - 150px);
        }

        /* Left Conversation Panel */
        .conversation-panel {
            width: var(--sidebar-width);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .conversation-header {
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .conversation-search {
            padding: 10px 15px;
        }

        .search-box {
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 8px 15px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            width: 100%;
        }

        .conversation-list {
            flex: 1;
            overflow-y: auto;
        }

        .conversation-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .conversation-item:hover,
        .conversation-item.active {
            background-color: var(--conversation-header-bg);
        }

        .conversation-avatar {
            position: relative;
            margin-right: 15px;
        }

        .conversation-avatar .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--primary-color);
            background-color: var(--conversation-header-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
        }

        .conversation-details {
            flex: 1;
            min-width: 0;
        }

        .conversation-top {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .conversation-name {
            font-weight: 500;
            font-size: 16px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .conversation-time {
            font-size: 12px;
            color: var(--light-text);
        }

        .conversation-preview {
            font-size: 14px;
            color: var(--light-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Chat Area */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            background-color: var(--chat-area-bg);
            background-image: url("uploads/default/dotflo/bg-chat.png");
            z-index: 0;
            /* so overlay is behind chat content */
        }

        .chat-area::before {
            content: "";
            position: absolute;
            inset: 0;
            /* shorthand for top:0; right:0; bottom:0; left:0 */
            background-color: #172c21b5;
            /* overlay color & opacity */
            z-index: 1;
            pointer-events: none;
            /* let clicks pass through */
        }

        .chat-area>* {
            position: relative;
            z-index: 2;
            /* ensure chat content is above overlay */


            .chat-header {
                padding: 15px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                z-index: 5;
            }

            .chat-contact {
                display: flex;
                align-items: center;
            }

            .chat-messages {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
            }

            .message-container {
                display: flex;
                margin-bottom: 10px;
                max-width: 80%;
            }

            .incoming {
                align-self: flex-start;
            }

            .outgoing {
                align-self: flex-end;
            }

            .message-bubble {
                padding: 8px 12px;
                border-radius: 7.5px;
                box-shadow: 0 1px 0.5px rgba(0, 0, 0, 0.13);
                position: relative;
                font-size: 14.2px;
                line-height: 1.4;
            }

            .incoming .message-bubble {
                background-color: var(--incoming-bg);
                border-top-left-radius: 0;
            }

            .outgoing .message-bubble {
                background-color: var(--outgoing-bg);
                border-top-right-radius: 0;
            }

            .message-time {
                font-size: 11px;
                color: var(--light-text);
                text-align: right;
                margin-top: 3px;
            }

            .chat-input {
                padding: 10px 15px;
                background-color: #f0f2f5;
                display: flex;
                align-items: center;
            }

            .input-tools {
                display: flex;
                gap: 15px;
                margin-right: 15px;
            }

            .message-input {
                flex: 1;
                background-color: white;
                border-radius: 20px;
                padding: 9px 12px;
                display: flex;
                align-items: center;
            }

            .message-input input {
                border: none;
                outline: none;
                width: 100%;
                font-size: 15px;
                padding: 5px 10px;
            }

            /* Side Panel */
            .side-panel {
                width: 380px;
                background-color: white;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease;
                z-index: 5;
            }

            .side-panel-header {
                padding: 15px;
                background-color: var(--primary-color);
                color: white;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .side-panel-content {
                flex: 1;
                padding: 20px;
                overflow-y: auto;
            }

            .no-conversation {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                text-align: center;
                padding: 20px;
                color: var(--light-text);
            }

            .no-conversation i {
                font-size: 80px;
                margin-bottom: 20px;
                color: #c0c0c0;
            }

            .no-conversation h3 {
                font-size: 22px;
                margin-bottom: 10px;
                color: var(--text-color);
            }


            @media (max-width: 992px) {
                .conversation-panel {
                    position: absolute;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    z-index: 100;
                    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                }

                .mobile-chat-header {
                    display: flex;
                    padding: 15px;
                    background-color: var(--primary-color);
                    color: white;
                    align-items: center;
                }
            }

            .empty-conversation {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                height: 100%;
                width: 100%;
                color: #6c757d;
            }

            #loading-screen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: white;
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: opacity 0.3s ease;
            }

            .loading-spinner {
                border: 4px solid #f3f3f3;
                border-radius: 50%;
                border-top: 4px solid #3498db;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
            }

            .symbol .whatsapp-icon {
                width: 14px;
                height: 14px;
                right: -2px;
                top: -2px;
            }


        }

        .message-input {
            background: #fff;
            border-radius: 20px;
            padding: 8px 12px;
            border: 1px solid #ddd;
        }



        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        [v-cloak] {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <style>
        .card .card-header {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            flex-wrap: wrap;
            min-height: 65px;
            padding: 0 2.25rem;
            color: var(--bs-card-cap-color);
            background-color: var(--bs-card-cap-bg);
        }

        .card .card-body {
            padding: 0rem 1.25rem;
            color: var(--bs-card-color);
        }
    </style>
    <div id="loading-screen">
        <div class="loading-spinner"></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('partials.flash')
            </div>
        </div>

        <div class="card card-custom border-0 shadow-sm">
            {{-- <div class="card-header border-0 bg-white">
                <h3 class="card-title font-weight-bolder text-dark">
                    <i class="flaticon2-chat-1 text-primary mr-2"></i> {{ __('Chat') }}
                </h3>
                <div class="card-toolbar">
                    <x-button-links />
                </div>
            </div> --}}

            <div class="card-body p-0" id="chatList">
                <div class="chat-container">
                    <!-- Left Conversation Panel -->
                    <div class="conversation-panel" v-if="conversationsShown">
                        <div class="conversation-header">
                            <h5 class="mb-0">Inbox</h5>
                            <div class="d-flex gap-2">
                                <!-- <button class="btn btn-sm btn-light">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-light">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button> -->
                            </div>
                        </div>

                        <div class="conversation-search">
                            @include('wpbox::chat.layout.header-conversations')
                        </div>

                        <div class="conversation-list">
                            @include('wpbox::chat.conversations')
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="chat-area flex-grow-1">
                        <!-- Mobile Chat Header -->
                        {{-- <div class="mobile-chat-header d-lg-none" v-if="!conversationsShown && activeChat">
                            <button @click="showConversations" class="btn btn-icon btn-light me-3">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <h5 class="mb-0">@{{ activeChat.name }}</h5>
                            <div></div> <!-- Spacer -->
                        </div> --}}

                        <div v-cloak class="h-100 d-flex flex-column">
                            <div v-if="activeChat && activeChat.name && contacts.length != 0"
                                class="d-flex flex-column h-100 w-100">
                                <div class="flex-grow-1 d-flex flex-column">
                                    @include('wpbox::chat.chat')
                                </div>
                            </div>
                            <div v-else class="no-conversation">
                                <i class="flaticon2-chat-1 text-muted"></i>
                                <h3 class="text-muted mt-3">No active conversation</h3>
                                <p class="text-muted">Select a conversation to start chatting</p>
                            </div>
                        </div>

                        <!-- Side Panel -->
                        <div class="side-panel" v-if="activeChat && activeChat.name"
                            :class="{ 'd-none d-lg-block': !isSideAppsVisible }">
                            @include('wpbox::chat.sideapps')
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('wpbox::chat.scripts')
        @foreach ($sidebarModules as $module)
            @include($module['script'])
        @endforeach
    </div>
    @include('wpbox::chat.onesignal')
    @include('wpbox::file_manager.popup_file_caption')
    <script>
        filemanager_request = 'chatroom';
    </script>
    <script src="{{ asset('vendor/emoji/emojiPicker.js') }}"></script>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loading-screen').style.opacity = '0';
            setTimeout(function() {
                document.getElementById('loading-screen').remove();
            }, 300);
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.opacity = '0';
            setTimeout(function() {
                document.body.style.transition = 'opacity 0.3s ease';
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
@endsection
