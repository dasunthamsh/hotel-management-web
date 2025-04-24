import './App.css';
import {BrowserRouter, Route, Routes } from "react-router-dom";

import { ReactNotifications } from 'react-notifications-component';
import 'react-notifications-component/dist/theme.css';
import {useState} from "react";
function App() {

    const [loggedInUser, setLoggedInUser] = useState(null);
    const handleLogin = (email) => {
        setLoggedInUser(email);
    };

    return (
    <div>
        <ReactNotifications />
        <BrowserRouter>
            <Routes>
            </Routes>
      </BrowserRouter>

    </div>
  );
}
// constants.js

export default App;
