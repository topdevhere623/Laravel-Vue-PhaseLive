import Vue from "vue";

/**
 * We could use a single event bus for all events but grouping them allows us to more easily see what part of the
 * application a specific event relates to.
 *
 * @type {CombinedVueInstance<*, *, *, *, Record<never, any>>}
 */
export const PlayerEvents = new Vue();
export const UserEvents = new Vue();
export const SocialEvents = new Vue();
export const MessageEvents = new Vue();
export const ModalEvents = new Vue();
export const GlobalEvents = new Vue();
