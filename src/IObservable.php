<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright      © 2017-2020, Niirrty
 * @package        Niirrty\Observer
 * @since          2017-11-01
 * @version        0.3.0
 */


declare( strict_types = 1 );


namespace Niirrty\Observer;


/**
 * Each observable object must implement this interface for interact with its observers.
 *
 * @since v0.1.0
 */
interface IObservable
{


    /**
     * Subscribe a new observer to this observable implementation.
     *
     * @param  IObserver $observer
     * @return IObservable
     */
    public function subscribe( IObserver $observer ) : IObservable;

    /**
     * Deletes the subscription of the defined observer (Observer will not longer be informed about something)
     *
     * If no observer is defined all observers will be removed.
     *
     * @param IObserver|null $observer
     * @return IObservable
     */
    public function unsubscribe( ?IObserver $observer = null ) : IObservable;

    /**
     * Notify all listening observers.
     *
     * @param  mixed $extras
     * @return IObservable
     */
    public function notify( $extras = null ) : IObservable;

    /**
     * Notify all listening observers. But here the observers are only notified if `notify(…)` is called after.
     *
     * @param  mixed $extras
     * @return IObservable
     */
    public function notifyCached( $extras = null ) : IObservable;

    /**
     * Gets if something is changed.
     *
     * @return bool
     */
    public function isChanged() : bool;

    /**
     * Resets the changed state to FALSE
     */
    public function clearChangedState();

    /**
     * Sets the changed state to TRUE.
     */
    public function setChanged();

    /**
     * Returns if one or more observers are subscribed.
     *
     * @return bool
     */
    public function hasObservers() : bool;

    /**
     * Gets the amount of registered observers.
     *
     * @return int
     */
    public function countObservers() : int;


}

