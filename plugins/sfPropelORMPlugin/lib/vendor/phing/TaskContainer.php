<?php
/*
 *  $Id: TaskContainer.php 123 2006-09-14 20:19:08Z mrook $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

/**
 *  Abstract interface for objects which can contain tasks (targets)
 *  Used to check if a class can contain tasks (via instanceof)
 *
 *  @author    Andreas Aderhold <andi@binarycloud.com>
 *  @copyright � 2001,2002 THYRELL. All rights reserved
 *  @version   $Revision: 1.5 $ $Date: 2006-09-14 20:19:08 +0000 (czw) $
 *  @access    public
 *  @package   phing
 */
interface TaskContainer {

    /**
     *  Adds a task to this task container. Must be implemented
     *  by derived class
     *
     *  @param  object  The task to be added to the container
     *  @access public
     */
    function addTask(Task $task);
}
