<?php
/**
 * @author         Ni Irrty <niirrty+code@gmail.com>
 * @copyright      © 2017-2021, Niirrty
 * @package        Niirrty\Observer
 * @since          2017-11-01
 * @version        0.4.0
 */


declare( strict_types = 1 );


namespace Niirrty\Observer;


/**
 * Defines all base functionality of an observable object
 */
abstract class Observable implements IObservable
{


    #region // – – –   P R O T E C T E D   F I E L D S   – – – – – – – – – – – – – – – – – – – – – –

    /**
     * All registered observers.
     *
     * @type IObserver[]
     */
    protected array $_observers;

    /**
     * Stores if something is changed
     *
     * @type boolean
     */
    protected bool $_changed;

    protected array $_cache;

    #endregion


    #region // – – –   P R O T E C T E D   C O N S T R U C T O R   – – – – – – – – – – – – – – – – –

    /**
     * Observable constructor.
     */
    protected function __construct()
    {

        $this->_observers = [];
        $this->_changed   = false;
        $this->_cache     = [];

    }

    #endregion


    #region // – – –   P U B L I C   M E T H O D S   – – – – – – – – – – – – – – – – – – – – – – – –

    /**
     * Subscribe a new observer to this observable implementation.
     *
     * @param IObserver $observer
     * @return IObservable
     */
    public function subscribe( IObserver $observer ) : IObservable
    {

        if ( ! \in_array( $observer, $this->_observers, true ) )
        {
            $this->_observers[] = $observer;
        }

        return $this;

    }

    /**
     * Deletes the subscription of the defined observer (Observer will not longer be informed about something)
     *
     * If no observer is defined all observers will be removed.
     *
     * @param IObserver|null $observer
     * @return IObservable
     */
    public function unsubscribe( ?IObserver $observer = null ) : IObservable
    {

        for ( $i = 0, $c = \count( $this->_observers ); $i < $c; $i++)
        {
            if ( $observer === $this->_observers[ $i ] )
            {
                unset( $this->_observers[ $i ] );
            }
        }

        $this->_observers = array_values( $this->_observers );

        return $this;

    }

    /**
     * Notify all subscribed observers
     *
     * @param mixed|null $extras
     *
     * @return IObservable
     */
    public function notify( mixed $extras = null ) : IObservable
    {

        if ( 1 < \count( $this->_cache ) )
        {
            $this->_cache[] = $extras;
        }
        else
        {
            $this->_cache = $extras;
        }

        foreach ( $this->_observers as $ob )
        {
            $ob->onUpdate( $this, $this->_cache );
        }

        $this->_cache = [];

        return $this;

    }

    /**
     * Notify all subscribed observers
     *
     * @param mixed|null $extras
     *
     * @return IObservable
     */
    public function notifyCached( mixed $extras = null ) : IObservable
    {

        $this->_cache[] = $extras;

        return $this;

    }

    /**
     * Gets if something is changed.
     *
     * @return bool
     */
    public function isChanged() : bool
    {

        return $this->_changed;

    }

    /**
     * Resets the changed state to FALSE
     */
    public function clearChangedState()
    {

        $this->_changed = false;

    }

    /**
     * Sets the changed state to TRUE.
     */
    public function setChanged()
    {

        $this->_changed = true;

    }

    /**
     * Returns if one or more observers are subscribed.
     *
     * @return bool
     */
    public function hasObservers() : bool
    {

        return 0 < $this->countObservers();

    }

    /**
     * Gets the amount of registered observers.
     *
     * @return int
     */
    public function countObservers() : int
    {

        return \count( $this->_observers );

    }

    #endregion


}

