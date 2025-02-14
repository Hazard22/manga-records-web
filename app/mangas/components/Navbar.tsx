'use client'

import { AppBar, Box, Toolbar, Typography } from "@mui/material"
import useUserStore from "@/app/store/userStore"
import AvatarMenu from "./AvatarMenu"

export default function Navbar() {

    const { user } = useUserStore()

    return (
        <header>
          <Box sx={{ flexGrow: 1 }}>
              <AppBar position="static">
                  <Toolbar>
                  <Typography variant="h6" component="div" sx={{ flexGrow: 1 }}>
                      Mangas
                  </Typography>
                  {user && <AvatarMenu/>}
                  </Toolbar>
              </AppBar>
          </Box>
        </header>
    )
}
