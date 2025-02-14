'use client'

import { Avatar, Box, Divider, IconButton, ListItemIcon, Menu, MenuItem, Typography } from '@mui/material'
import React, { useEffect, useState } from 'react'
import { getAuth, signOut } from 'firebase/auth';
import { CiLogout } from 'react-icons/ci';
import useUserStore from '@/app/store/userStore';
import { firebase } from '@/app/services/firebaseConfig';
import { useRouter } from 'next/navigation';
import { deleteCookie, hasCookie } from 'cookies-next';


export default function AvatarMenu() {

    const { user, updateUser } = useUserStore()
    const auth = getAuth(firebase)
    const router = useRouter()
    
    const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
    const [loading, setLoading] = useState(false)

    const open = Boolean(anchorEl);

    const handleMenu = (event: React.MouseEvent<HTMLElement>) => {
        setAnchorEl(event.currentTarget);
    };

    const handleClose = () => {
        setAnchorEl(null);
    };

    const handleLogout = async () => {  
        setLoading(true)
        try {
            await signOut(auth)
            updateUser(null)
            deleteCookie('userCookie')
            router.push('/');
        } catch (error: unknown) {
            if (error instanceof Error) {
            console.error("Error al cerrar sesión:", error.message);
            } else {
            console.error("Error desconocido al cerrar sesión", error);
            }
        }
        setLoading(false)
    }    

    return (
        <div>
            <IconButton
            size="large"
            aria-label="account of current user"
            aria-controls="menu-appbar"
            aria-haspopup="true"
            onClick={handleMenu}
            color="inherit"
            >
                <Avatar alt='UserPhoto' src={`${user?.photoURL}`}/>
            </IconButton>
            <Menu
            anchorEl={anchorEl}
            id="account-menu"
            open={open}
            onClose={handleClose}
            onClick={handleClose}
            slotProps={{
            paper: {
                elevation: 0,
                sx: {
                overflow: 'visible',
                filter: 'drop-shadow(0px 2px 8px rgba(0,0,0,0.32))',
                mt: 1.5,
                '& .MuiAvatar-root': {
                    width: 32,
                    height: 32,
                    ml: -0.5,
                    mr: 1,
                },
                '&::before': {
                    content: '""',
                    display: 'block',
                    position: 'absolute',
                    top: 0,
                    right: 14,
                    width: 10,
                    height: 10,
                    bgcolor: 'background.paper',
                    transform: 'translateY(-50%) rotate(45deg)',
                    zIndex: 0,
                },
                },
            },
            }}
            transformOrigin={{ horizontal: 'right', vertical: 'top' }}
            anchorOrigin={{ horizontal: 'right', vertical: 'bottom' }}
        >
            <Box 
            sx={{
                bgcolor: '#1e1e1e',
                borderRadius: 2,
                p: 2,
                m: 2,
                minWidth: 250,
                pointerEvents: 'none'
            }}>
                <Typography variant='subtitle1'>{user?.displayName}</Typography>
                <Typography variant='subtitle2'>{user?.email}</Typography>
            </Box>
            <Divider />
            <MenuItem onClick={handleLogout}>
            <ListItemIcon>
                <CiLogout/>
            </ListItemIcon>
            Logout
            </MenuItem>
        </Menu>
        </div>
    )
}
